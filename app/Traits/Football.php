<?php

namespace App\Traits;

use App\Models\Football\Match;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Storage;

trait Football
{
    /**
     * @var Client
     */
    private $_api;

    private function _footballIsEnable()
    {
        if (! is_null(env('FOOTBALL_TEAM_NAME')) && ! is_null(env('FOOTBALL_CHAMPIONSHIP'))) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @return $this
     */
    private function _initApi($type = null)
    {
        if (is_null($type)) {
            $type = self::FOOTBALL_API_URL;
        }

        $this->_api = new Client([
            'base_uri' => $type,
            'timeout' => 5.0,
        ]);

        return $this;
    }

    /**
     * @return mixed
     */
    private function _getJsonForCalendar()
    {
        if (is_null($this->_api)) {
            $this->_initApi(self::CALENDAR_URL);
        }

        return \GuzzleHttp\json_decode($this->_api->get(env('FOOTBALL_CHAMPIONSHIP', 'D2') . '.ijson')->getBody()->getContents(), true);
    }

    /**
     * @return mixed
     */
    private function _getJsonForRanking()
    {
        if (is_null($this->_api)) {
            $this->_initApi(self::RANKING_URL);
        }

        return \GuzzleHttp\json_decode($this->_api->get(env('FOOTBALL_CHAMPIONSHIP', 'D2') . '/general/fr.ijson')->getBody()->getContents(), true);
    }

    /**
     * Télécharge le logo de l'équipe s'il est innexistant.
     *
     * @param int    $team_id
     * @param string $path
     */
    private function _downloadLogo(int $team_id, string $path)
    {
        if (! Storage::exists('football/logos/' . $team_id . '.png')) {
            Storage::put('football/logos/' . $team_id . '.png', file_get_contents($path, false, stream_context_create([
                'ssl' => [
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                ],
            ])));
        }
    }

    /**
     * Donne le dernier match joué par l'équipe.
     *
     * @return Match|void
     */
    private function _lastMatch()
    {
        if (! empty(env('FOOTBALL_TEAM_NAME'))) {
            return Match::where('statut', '!=', 'P')->orderBy('date', 'DESC')->first();
        }
    }

    /**
     * @return mixed
     */
    private function _nextMatch()
    {
        if (! empty(env('FOOTBALL_TEAM_NAME'))) {
            return Match::where('statut', '=', 'P')->orderBy('date', 'ASC')->first();
        }
    }
}
