<?php

namespace App\Console\Commands\Imports\Football;

use App\Interfaces\Football;
use App\Models\Football\Season;
use Illuminate\Console\Command;

class Seasons extends Command implements Football
{
    use \App\Traits\Football;
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
        $season = $this->_getSeasons();

        $this->output->writeln('Saison ' . $season->championship . ' - ' . $season->name);
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
