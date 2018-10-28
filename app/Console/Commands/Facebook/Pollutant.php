<?php

namespace App\Console\Commands\Facebook;

use Illuminate\Console\Command;
use Imagick;
use ImagickDraw;
use ImagickPixel;

class Pollutant extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'facebook:pollutant';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Génére le post sur la pollution';

    /**
     * @var string
     */
    private $_filename;

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
        $this->_generateImage('horizontal')->_sendToFacebook();
    }

    /**
     * @throws \Facebook\Exceptions\FacebookSDKException
     *
     * @return $this
     */
    private function _sendToFacebook()
    {
        /* @var \Facebook\Facebook $facebook */
        $facebook = resolve('facebook');

        $data = [
            'message' => trans('pollutants.message', ['date' => date('d/m/Y')]),
            'source' => $facebook->fileToUpload($this->_filename),
        ];

        try {
            // Returns a `Facebook\FacebookResponse` object
            $response = $facebook->post('/' . env('FACEBOOK_ALBUM_ID_POLLUTANT') . '/photos', $data, env('FACEBOOK_LONG_LIFE_TOKEN'));
        } catch (\Facebook\Exceptions\FacebookResponseException $e) {
            $this->error('Graph returned an error: ' . $e->getMessage());
            exit;
        } catch (\Facebook\Exceptions\FacebookSDKException $e) {
            $this->error('Facebook SDK returned an error: ' . $e->getMessage());
            exit;
        }

        $this->output->writeln('Upload fait sur Facebook (' . $response->getGraphNode()['id'] . ')');

        return $this;
    }

    /**
     * @throws \ImagickException
     *
     * @return $this
     */
    private function _generateImage($mode = 'horizontal')
    {
        $positions = [
            'vertical' => [
                'cols' => 2100,
                'rows' => 780,
                'start' => [
                    'x' => 25,
                    'y' => 80,
                ],
                'add' => [
                    'x' => 700,
                    'y' => 0,
                ],
                'today' => [
                    'x' => 280,
                    'y' => 45,
                ],
                'tomorrow' => [
                    'x' => 980,
                    'y' => 45,
                ],
                'aftertomorrow' => [
                    'x' => 1680,
                    'y' => 45,
                ],
                'copyright' => [
                    'x' => 1300,
                    'y' => 760,
                ],
            ],
            'horizontal' => [
                'cols' => 750,
                'rows' => 2300,
                'start' => [
                    'x' => 50,
                    'y' => 100,
                ],
                'add' => [
                    'x' => 0,
                    'y' => 720,
                ],
                'today' => [
                    'x' => 310,
                    'y' => 45,
                ],
                'tomorrow' => [
                    'x' => 310,
                    'y' => 800,
                ],
                'aftertomorrow' => [
                    'x' => 310,
                    'y' => 1520,
                ],
                'copyright' => [
                    'x' => 10,
                    'y' => 2250,
                ],
            ],
        ];

        $this->output->writeln('Création de l\'image de prévision de la qualité de l\'air');
        $image = new Imagick();
        $image->newImage($positions[$mode]['cols'], $positions[$mode]['rows'], new ImagickPixel('white'));
        $image->setImageFormat('png');
        $startX = $positions[$mode]['start']['x'];
        $startY = $positions[$mode]['start']['y'];

        foreach (['MOYJ0', 'MOYJ1', 'MOYJ2'] as $type) {
            $prevision = new \Imagick(storage_path('app/public/pollutants') . '/' . $type . '_' . date('Y-m-d') . '.png');
            $image->compositeImage($prevision, \Imagick::COMPOSITE_DEFAULT, $startX, $startY);
            $startX += $positions[$mode]['add']['x'];
            $startY += $positions[$mode]['add']['y'];
        }

        $draw = new ImagickDraw();
        $draw->setFillColor(new ImagickPixel('black'));
        $draw->setFontSize(24);

        $image->annotateImage($draw, $positions[$mode]['today']['x'], $positions[$mode]['today']['y'], 0, trans('pollutants.today'));
        $image->annotateImage($draw, $positions[$mode]['tomorrow']['x'], $positions[$mode]['tomorrow']['y'], 0, trans('pollutants.tomorrow'));
        $image->annotateImage($draw, $positions[$mode]['aftertomorrow']['x'], $positions[$mode]['aftertomorrow']['y'], 0, trans('pollutants.aftertomorrow'));

        $draw->setFillColor(new ImagickPixel('grey'));
        $draw->setFontSize(18);
        $image->annotateImage($draw, $positions[$mode]['copyright']['x'], $positions[$mode]['copyright']['y'], 0, trans('pollutants.copyright'));

        $this->_filename = storage_path('app/public/pollutants') . '/previsions_' . date('Y-m-d') . '.png';

        $image->writeImage($this->_filename);

        return $this;
    }
}
