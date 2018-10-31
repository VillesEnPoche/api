<?php

namespace App\Console\Commands\Imports\Rugby;

use App\Models\Rugby\Match;
use App\Models\Rugby\Phase;
use App\Traits\RocketChat;
use App\Traits\Rugby;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Console\Command;

class Matchs extends Command
{
    use RocketChat, Rugby;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:rugby:matchs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Importes les matchs de rugby';

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
        if (! empty(env('RUGBY_FFR_API')) && ! empty(env('RUGBY_FFR_ID'))) {
            $this->_getCalendar();
        }
    }

    private function _getCalendar()
    {
        $json = \GuzzleHttp\json_decode(file_get_contents(env('RUGBY_FFR_API') . '/journees'), true);
        if (! empty($json)) {
            foreach ($json as $journee) {
                $phase = Phase::firstOrCreate([
                    'phase_id' => $journee['competitions_phase']['id'],
                ], [
                    'name' => $journee['competitions_phase']['nom'],
                    'championship' => $journee['competitions_phase']['competition']['nom'],
                ]);
                if (! empty($journee['poules'])) {
                    foreach ($journee['poules'] as $poule) {
                        foreach ($poule['rencontres'] as $rencontre) {
                            if ($rencontre['local_structure']['id'] == env('RUGBY_FFR_ID') || $rencontre['visitor_structure']['id'] == env('RUGBY_FFR_ID')) {
                                Match::updateOrCreate([
                                    'ffr_id' => $rencontre['id'],
                                ], [
                                    'phase_id' => $phase->id,
                                    'date' => Carbon::createFromTimeString($rencontre['date']),
                                    'statut' => $rencontre['statut'],
                                    't1_score' => $rencontre['score_structure_locale'],
                                    't2_score' => $rencontre['score_structure_visiteur'],
                                    't1_name' => $rencontre['local_structure']['nom'],
                                    't2_name' => $rencontre['visitor_structure']['nom'],
                                    't1_city' => $rencontre['local_structure']['ville'],
                                    't2_city' => $rencontre['visitor_structure']['ville'],
                                    'terrain' => $rencontre['terrain']['nom'],
                                ]);
                                if ($rencontre['local_structure']['logo']) {
                                    $this->_downloadLogoRugby($rencontre['local_structure']['identifiant']);
                                }
                                if ($rencontre['visitor_structure']['logo']) {
                                    $this->_downloadLogoRugby($rencontre['visitor_structure']['identifiant']);
                                }
                            }
                        }
                    }
                }
            }

            $this->sendToRocketChat(['text' => 'Import des matchs de rugby fini.']);
        }
    }
}
