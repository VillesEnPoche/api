<?php

namespace App\Console\Commands\Imports;

use App\Models\Ter;
use App\Models\Ters\Detail;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\ServerException;
use Illuminate\Console\Command;

class TERCommand extends Command
{
    const TER_API = 'https://ter-apps.bkt.mobi';
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:ter';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import des TER';

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
        $this->_api = new Client([
            'base_uri' => self::TER_API,
            'timeout' => 5.0,
        ]);

        $this->_getData();
    }

    /**
     * Récupère les données principales.
     *
     * @return $this
     */
    private function _getData()
    {
        foreach (['arrivals', 'departures'] as $data) {
            $this->output->writeln($data);
            $json = \GuzzleHttp\json_decode($this->_api->get('station?data=' . $data . '&uic=' . env('TER_ID'))->getBody()->getContents(), true);
            Ter::updateOrCreate([
                'day' => date('Y-m-d'),
                'data' => $data,
            ], [
                'json' => $json,
            ]);

            foreach ($json[$data] as $train) {
                $this->_getDetails($train);
            }
        }

        return $this;
    }

    /**
     * Récupère les données de chaque train.
     *
     * @param array $train
     *
     * @return $this
     */
    private function _getDetails(array $train, $retry = 0)
    {
        $this->output->writeln('Detail for ' . $train['numero']);
        try {
            $json = \GuzzleHttp\json_decode($this->_api->get('train?number=' . $train['numero'] . '&uic=' . env('TER_ID'))->getBody()->getContents(), true);
            Detail::updateOrCreate([
                'number' => $train['numero'],
            ], [
                'json' => $json,
            ]);
        } catch (ConnectException $e) {
            $retry++;
            if ($retry > 3) {
                throw new \Exception($e->getMessage());
            }
            $this->output->error('Retry for ' . $train['numero'] . '(' . $retry . ')');
            $this->_getDetails($train, $retry);
        } catch (ServerException $e) {
        }

        return $this;
    }
}
