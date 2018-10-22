<?php

namespace App\Console\Commands;

use App\Models\Pollutant;
use App\Models\Pollutants\History;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Process\Process;

class PrevairCommand extends Command
{
    /**
     * URL des fichiers prevair.
     */
    const BASE_API_URL = 'http://www.prevair.org/donneesmisadispo/public/PREVAIR.';

    /**
     * Types des fichiers à télécharger.
     */
    const TYPES = ['prevision' => ['MOYJ0', 'MOYJ1', 'MOYJ2', 'MOYJ3', 'MAXJ0', 'MAXJ1', 'MAXJ2', 'MAXJ3'], 'analyse' => ['MAXJ', 'MOYJ']];

    const DIR_FILES = 'pollutants';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'prevair:import {day? : Date souhaitée YYYYMMDD}';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Importe les données de la qualité de l\'air';

    private $_day;
    private $_yesterday;
    private $_files = [];

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
        $this->_day = $this->argument('day');
        if (is_null($this->_day)) {
            $this->_day = (Carbon::now()->format('Ymd'));
        }

        $this->_yesterday = (Carbon::createFromFormat('Ymd', $this->_day))->subDay()->format('Ymd');

        $this->_downloadFiles()
            ->_extractDatas();
    }

    /**
     * Extrait les données via ncks et les inserts en BDD.
     */
    private function _extractDatas()
    {
        if (count($this->_files)) {
            foreach ($this->_files as $infos) {
                $process = new Process('ncks -s "%f" -C -H -d lat,' . getenv('LATITUDE') . ' -d lon,' . getenv('LONGITUDE') . ' -v ' . $infos['pollutant']->cdf_name . ' ' . storage_path('app/' . self::DIR_FILES . '/' . $infos['name']));
                $process->run();
                $this->output->writeln($infos['pollutant']->name . ' - ' . $infos['var'] . ' : ' . trim($process->getOutput()));

                History::updateOrCreate([
                    'type' => $infos['type'],
                    'var' => $infos['var'],
                    'date' => $infos['date'],
                    'pollutant_id' => $infos['pollutant']->id,
                ], [
                    'alert' => $infos['pollutant']->getAlert(floatval(trim($process->getOutput()))),
                    'value' => floatval(trim($process->getOutput())),
                ]);
            }
        }
    }

    /**
     * Télécharge tous les fichiers sur les polluants.
     *
     * @return $this
     */
    private function _downloadFiles()
    {
        $pollutants = Pollutant::all();
        $this->output->writeln('Download pollutants files');
        foreach (self::TYPES as $type => $vars) {
            foreach ($vars as $var) {
                foreach ($pollutants as $pollutant) {
                    $date = $this->_day;
                    if ($type == 'analyse') {
                        $date = $this->_yesterday;
                    }
                    $url = self::BASE_API_URL . $type . '.' . $date . '.' . $var . '.' . $pollutant->acronym . '.public.nc';

                    $name = substr($url, strrpos($url, '/') + 1);
                    if (! Storage::exists(self::DIR_FILES . '/' . $name)) {
                        $this->output->writeln('Download ' . $url);
                        try {
                            $contents = file_get_contents($url);
                        } catch (\Exception $e) {
                            error_log($url . ' ' . $e->getMessage());
                        }
                        Storage::put(self::DIR_FILES . '/' . $name, $contents);
                    }
                    $this->_files[] = [
                        'pollutant' => $pollutant,
                        'name' => $name,
                        'type' => $type,
                        'var' => $var,
                        'date' => $date,
                    ];
                }
            }
        }

        return $this;
    }
}
