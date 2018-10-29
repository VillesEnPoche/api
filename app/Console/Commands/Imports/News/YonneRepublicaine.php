<?php

namespace App\Console\Commands\Imports\News;

use App\Models\Article;
use App\Models\Articles\Partner;
use App\Traits\Facebook;
use App\Traits\Twitter;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class YonneRepublicaine extends Command
{
    use Facebook, Twitter;

    const YONNE_REP_JSON = 'https://www.lyonne.fr/mobileapp/articles?limit=5&offset=0&code_insee=';
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:news:yonnerepublicaine';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Importe les news de l\'Yonne Républicaine';

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
        $this->_getArticles();
    }

    /**
     * @throws \Facebook\Exceptions\FacebookSDKException
     */
    private function _getArticles()
    {
        $json = \GuzzleHttp\json_decode(file_get_contents(self::YONNE_REP_JSON . env('CITY_INSEE', 89024)), true);
        $partner = Partner::where('command', '=', $this->signature)->select(['id', 'twitter'])->first();
        $authors = $partner->authors()->select(['name', 'twitter'])->get()->toArray();
        foreach ($json['articles'] as $article) {
            $path_image = 'news/yonnerep/' . str_slug($article['titre'] . '-' . $article['uid']) . '.jpg';
            if (! Storage::exists($path_image)) {
                Storage::put($path_image, file_get_contents($article['imageURL']));
            }

            $a = Article::updateOrCreate([
                'unique_id' => $article['uid'],
                'partner_id' => $partner->id,
            ], [
                'title' => $article['titre'],
                'content' => $article['chapo'],
                'date' => Carbon::createFromTimestamp($article['datePublication']),
                'href' => $article['shareURL'] . '?utm_source=' . env('PARTNER_UTM_SOURCE'),
                'image' => $path_image,
            ]);

            // L'article vient d'être créé, on le pousse sur les réseaux sociaux
            if ($a->wasRecentlyCreated) {
                if ($this->canUseFacebook()) {
                    $this->_sendLinkToFacebook($article->href);
                }

                if ($this->canUseTwitter()) {
                    $status = '#' . env('TWITTER_HASHTAG') . ' ' . substr($a->title, 0, 90).'... ' . $a->href . ' via @' . $partner->twitter;
                    $users = $this->_searchAuthors($authors, $article['contenu']);
                    if (count($users)) {
                        $status .= ', ' . implode(', ', $users);
                    }
                    $this->_sendToTwitter($status, Storage::path($path_image));
                }
            }
        }
    }
}
