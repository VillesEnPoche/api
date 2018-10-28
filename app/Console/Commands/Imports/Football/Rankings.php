<?php

namespace App\Console\Commands\Imports\Football;

use App\Interfaces\Football;
use App\Models\Football\Ranking;
use App\Models\Football\Season;
use Illuminate\Console\Command;

class Rankings extends Command implements Football
{
    use \App\Traits\Football;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:football:rankings';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Importe le classement de la saison';

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
        $json = $this->_getJsonForRanking();

        foreach ($json['flux'] as $ranking) {
            Ranking::updateOrCreate([
                'season_id' => Season::select('id')->where('fff_id', '=', $ranking['fk_comp_id'])->first()->id,
                'team_id' => $ranking['fk_team_id'],
            ], [
                'team_name' => $ranking['rank_team_name'],
                'position' => $ranking['rank_pos'],
                'evolution' => $ranking['rank_evo'],
                'played' => $ranking['rank_played'],
                'points' => $ranking['rank_pts'],
                'win' => $ranking['rank_win'],
                'drawn' => $ranking['rank_drawn'],
                'lose' => $ranking['rank_lose'],
                'gf' => $ranking['rank_gf'],
                'ga' => $ranking['rank_ga'],
                'diff' => $ranking['rank_diff'],
                'day' => $ranking['rank_day'],
            ]);
        }
    }
}
