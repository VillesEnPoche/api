<?php

namespace App\Console\Commands\Imports;

use App\Models\Theaters\Movie;
use App\Models\Theaters\Movies\Time;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Imagick;

class TheaterCommand extends Command
{
    const WAIT_TIME = 20;

    const ALLOCINE_API_URL = 'https://api.allocine.fr/rest/v3/';
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:theater {--days=10}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import les films d\'un cinéma';

    /**
     * @var Client
     */
    private $_api;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if (! $this->_isActive()) {
            return;
        }

        $this->_initApi()->_getShowtime();
    }

    /**
     * Controle si la tâche doit tourner.
     *
     * @return bool
     */
    private function _isActive()
    {
        if (! empty(env('ALLOCINE_PARTNER_KEY')) && ! empty(env('ALLOCINE_SECRET_KEY')) && ! empty(env('ALLOCINE_THEATER_ID'))) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Récupère la liste des films pour un jour donné.
     */
    private function _getShowtime()
    {
        $day = Carbon::now();
        for ($i = 1; $i <= $this->option('days'); $i++) {
            $this->output->writeln('Showtime pour le ' . $day->format('d/m/Y'));
            $feed = \GuzzleHttp\json_decode($this->_createRequest('showtimelist', [
                'partner' => env('ALLOCINE_PARTNER_KEY'),
                'date' => $day->format('Y-m-d'),
                'format' => 'json',
                'profile' => 'large',
                'theaters' => getenv('ALLOCINE_THEATER_ID'),
                'count' => '100',
            ])->getBody()->getContents(), true);

            $this->_parseMovies($feed);

            $day->addDay();
        }
    }

    /**
     * Génére l'URL pour l'appel.
     *
     * @param $method
     * @param $params
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    private function _createRequest($method, $params)
    {
        sleep(self::WAIT_TIME);
        // new algo to build the query
        $sed = date('Ymd');
        $sig = urlencode(base64_encode(sha1(env('ALLOCINE_SECRET_KEY') . http_build_query($params) . '&sed=' . $sed, true)));

        return $this->_api->get($method . '?' . http_build_query($params) . '&sed=' . $sed . '&sig=' . $sig);
    }

    /**
     * @param array $feed
     */
    private function _parseMovies(array $feed)
    {
        if (! empty($feed['feed']['theaterShowtimes'][0]['movieShowtimes'])) {
            foreach ($feed['feed']['theaterShowtimes'][0]['movieShowtimes'] as $data) {
                // On télécharge l'affiche si elle n'existe pas
                $path_poster = 'theater/' . $data['onShow']['movie']['code'] . '-' . str_slug($data['onShow']['movie']['title']) . '.jpg';
                if (! Storage::exists($path_poster) && ! empty($data['onShow']['movie']['poster']['href'])) {
                    $this->output->writeln('Téléchargement de l\'affiche pour ' . $data['onShow']['movie']['title']);
                    Storage::put($path_poster, file_get_contents($data['onShow']['movie']['poster']['href']));
                }
                $this->_resizeImage($path_poster);
                $genres = [];
                foreach ($data['onShow']['movie']['genre'] as $genre) {
                    $genres[] = $genre['$'];
                }

                $movie = Movie::updateOrCreate([
                    'code_id' => $data['onShow']['movie']['code'],
                ], [
                    'title' => $data['onShow']['movie']['title'],
                    'actors' => (! empty($data['onShow']['movie']['castingShort']['actors'])) ? explode(', ', $data['onShow']['movie']['castingShort']['actors']) : null,
                    'directors' => (! empty($data['onShow']['movie']['castingShort']['directors'])) ? explode(', ', $data['onShow']['movie']['castingShort']['directors']) : null,
                    'genres' => $genres,
                    'synopsis' => $this->_getSynopsis($data['onShow']['movie']['code']),
                    'path_poster' => $path_poster,
                    'path_trailer' => (! empty($data['onShow']['movie']['trailer']['code'])) ? $this->_getTrailer(intval($data['onShow']['movie']['trailer']['code'])) : null,
                    'runtime' => (! empty($data['onShow']['movie']['runtime'])) ? $data['onShow']['movie']['runtime'] : null,
                    'rating' => (! empty($data['onShow']['movie']['statistics']['userRating'])) ? floatval($data['onShow']['movie']['statistics']['userRating']) : null,
                    'release' => (! empty($data['onShow']['movie']['release']['releaseDate'])) ? $data['onShow']['movie']['release']['releaseDate'] : null,
                ]);

                // Ajout des horaires
                foreach ($data['scr'][0]['t'] as $hours) {
                    Time::updateOrCreate([
                        'movie_id' => $movie->id,
                        'date' => $data['scr'][0]['d'] . ' ' . $hours['$'] . ':00',
                        'is_3d' => ($data['screenFormat']['$'] == '3D') ? true : false,
                    ], [
                        'is_original' => ($data['version']['original'] == 'true') ? true : false,
                        'lang' => (! empty($data['version']['$'])) ? $data['version']['$'] : null,
                    ]);
                }
            }
        }
    }

    /**
     * Reformatte les images.
     *
     * @param $path
     *
     * @return TheaterCommand
     */
    private function _resizeImage($path)
    {
        $formats = [
            'big' => 850,
            'medium' => 550,
            'small' => 250,
        ];

        foreach ($formats as $name => $size) {
            if (! Storage::exists(str_replace('theater', 'theater/' . $name, $path))
                && Storage::exists($path)) {
                try {
                    $this->output->writeln('Resize ' . $name . ' pour ' . $path);
                    $thumb = new Imagick();
                    $thumb->readImage(Storage::path($path));
                    $thumb->resizeImage($size, 0, Imagick::FILTER_LANCZOS, 1);
                    Storage::put(str_replace('theater', 'theater/' . $name, $path), $thumb->getImageBlob());
                    $thumb->clear();
                    $thumb->destroy();
                } catch (\ImagickException $e) {
                }
            }
        }

        return $this;
    }

    /**
     * Retourne l'url du média.
     *
     * @param int $code
     */
    private function _getTrailer(int $code)
    {
        $feed = \GuzzleHttp\json_decode($this->_createRequest('media', [
            'partner' => env('ALLOCINE_PARTNER_KEY'),
            'code' => $code,
            'format' => 'json',
            'profile' => 'large',
            'mediafmt' => 'mp4-lc:m',
            'sed' => date('Ymd'),
        ])->getBody()->getContents(), true);

        if (! empty($feed['media']['rendition'][0]['href'])) {
            return $feed['media']['rendition'][0]['href'];
        } else {
            return;
        }
    }

    private function _getSynopsis(int $code)
    {
        try {
            $feed = \GuzzleHttp\json_decode($this->_createRequest('movie', [
            'partner' => env('ALLOCINE_PARTNER_KEY'),
            'code' => $code,
            'profile' => 'large',
            'filter' => 'movie',
            'striptags' => 'synopsis,synopsisshort',
            'format' => 'json',
            'sed' => date('Ymd'),
            ])->getBody()->getContents(), true);

            if (! empty($feed['movie']['synopsis'])) {
                return $feed['movie']['synopsis'];
            } else {
                return;
            }
        } catch (\Exception $e) {
            $this->output->error($e->getMessage());
        }
    }

    /**
     * @return $this
     */
    private function _initApi()
    {
        $this->_api = new Client([
            'base_uri' => self::ALLOCINE_API_URL,
            'timeout' => 10,
            'headers' => ['User-Agent' => 'Dalvik/1.6.0 (Linux; U; Android 4.2.2; Nexus 4 Build/JDQ39E)'],
        ]);

        return $this;
    }
}
