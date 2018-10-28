<?php

namespace App\Console\Commands\Imports\Football;

use App\Interfaces\Football;
use App\Models\Football\Match;
use App\Models\Football\Season;
use Carbon\Carbon;
use Illuminate\Console\Command;

class Matchs extends Command implements Football
{
    use \App\Traits\Football;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:football:matchs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Importe le calendrier des matchs de la saison';

    /**
     * @var Season
     */
    private $_season;

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
        $json = $this->_getJsonForCalendar();

        $this->_getSeasonId($json);

        foreach ($json['index'] as $day) {
            foreach ($json['flux'][$day] as $match) {
                if ($match['match_t1_name'] === env('FOOTBALL_TEAM_NAME') || $match['match_t2_name'] === env('FOOTBALL_TEAM_NAME')) {
                    Match::updateOrCreate([
                        'fff_id' => $match['match_id_fff'],
                    ], [
                        'season_id' => $this->_season->id,
                        't1_name' => $match['match_t1_name'],
                        't2_name' => $match['match_t2_name'],
                        't1_id' => $match['match_t1_id'],
                        't2_id' => $match['match_t2_id'],
                        't1_score' => $match['match_s1'],
                        't2_score' => $match['match_s2'],
                        'statut' => $match['match_statut'],
                        'day' => $match['match_day'],
                        'date' => Carbon::createFromFormat('d/m/Y H:i', $match['match_date'] . ' ' . $match['match_time']),
                        'diffuser' => $match['match_diffuseur'],
                        'stade_name' => $match['match_stade_name'],
                        'twitter' => $match['match_twitter'],
                    ]);

                    $this->_downloadLogo($match['match_t1_id'], $match['match_t1_logo_hd']);
                    $this->_downloadLogo($match['match_t2_id'], $match['match_t2_logo_hd']);
                }
            }
        }
    }

    /**
     * @param array $json
     *
     * @return $this
     */
    private function _getSeasonId(array $json)
    {
        $this->_season = Season::where('fff_id', '=', $json['comp']['comp_id'])->first();

        return $this;
    }
}
