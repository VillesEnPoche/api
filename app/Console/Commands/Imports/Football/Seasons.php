<?php

namespace App\Console\Commands\Imports\Football;

use App\Interfaces\Football;
use App\Models\Football\Season;
use App\Traits\RocketChat;
use Illuminate\Console\Command;

class Seasons extends Command implements Football
{
    use \App\Traits\Football, RocketChat;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:football:seasons';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Importe les saisons';

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
        if (! $this->_footballIsEnable()) {
            exit(0);
        }

        $season = $this->_getSeasons();

        $this->output->writeln('Saison ' . $season->championship . ' - ' . $season->name);

        $this->sendToRocketChat(['text' => 'Import des saisons de football fini']);
    }

    /**
     * @return Season
     */
    private function _getSeasons()
    {
        $json = $this->_getJsonForCalendar();

        return Season::firstOrCreate([
            'fff_id' => $json['comp']['comp_id'],
        ], [
            'name' => $json['comp']['comp_season'],
            'championship' => $json['comp']['comp_name'],
        ]);
    }
}
