<?php

namespace App\Console\Commands;

use App\Models\Gas\Price;
use App\Models\Gas\Station;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class GasStationCommand extends Command
{
    const API_URL = 'https://donnees.roulez-eco.fr/opendata/instantane';
    const DIR_FILES = 'gas';
    const FILE_NAME = 'PrixCarburants_instantane.xml';
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gas:import';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Importe les tarifs des stations essences';
    private $_name;

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
        if ($this->_downloadFile()->_unzipFile()) {
            $this->_searchStations();
        }
    }

    /**
     * Recherche les stations présentes en base pour MAJ les datas.
     */
    private function _searchStations()
    {
        $pvids = Station::pluck('pvid')->toArray();
        $this->output->writeln('Search stations in XML file');
        $xml = simplexml_load_string(Storage::get(self::DIR_FILES . '/' . self::FILE_NAME));

        foreach ($xml->pdv as $pdv) {
            $id = $pdv->attributes()->id->__toString();
            if (in_array($id, $pvids)) {
                $station = Station::where('pvid', '=', $id)->first();
                $this->output->writeln('Station ' . $station->name . ' (' . $station->pvid . ')');
                foreach ($pdv->prix as $prix) {
                    Price::updateOrCreate([
                        'station_id' => $station->id,
                        'gas' => $prix->attributes()->nom->__toString(),
                    ], [
                        'price' => $prix->attributes()->valeur->__toString(),
                        'created_at' => $prix->attributes()->maj->__toString(),
                    ]);
                }
            }
        }
    }

    /**
     * Dézippe le fichier des prix.
     *
     * @return bool
     */
    private function _unzipFile(): bool
    {
        $zip = new ZipArchive();
        $this->output->writeln('Dezip ' . storage_path('app/' . self::DIR_FILES . '/' . $this->_name));
        if ($zip->open(storage_path('app/' . self::DIR_FILES . '/' . $this->_name)) === true) {
            $zip->extractTo(storage_path('app/' . self::DIR_FILES . '/'));
            $zip->close();

            return true;
        }

        return false;
    }

    private function _downloadFile(): self
    {
        $this->_name = 'prices_' . date('Y-m-d-H-i') . '.zip';
        $this->output->writeln('Download ' . self::API_URL);
        try {
            $contents = file_get_contents(self::API_URL);
        } catch (\Exception $e) {
            error_log(self::API_URL . ' ' . $e->getMessage());
        }
        $this->output->writeln('Filename : ' . self::DIR_FILES . '/' . $this->_name);
        Storage::put(self::DIR_FILES . '/' . $this->_name, $contents);

        return $this;
    }
}
