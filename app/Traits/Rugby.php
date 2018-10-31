<?php

namespace App\Traits;

use App\Models\Rugby\Match;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Storage;

trait Rugby
{
    /**
     * @var Client
     */
    private $_api;

    private function _rugbyIsEnable()
    {
        if (! is_null(env('RUGBY_FFR_ID')) && ! is_null(env('RUGBY_FFR_API'))) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Télécharge le logo de l'équipe s'il est innexistant.
     *
     * @param string $logo
     */
    private function _downloadLogoRugby(string $logo)
    {
        if (! Storage::exists('rugby/' . $logo . '.jpg')) {
            Storage::put('rugby/' . $logo . '.jpg', file_get_contents('https://competitions.ffr.fr/api/logo/' . $logo . '.jpeg'));
        }
    }

    /**
     * Donne le dernier match joué par l'équipe.
     *
     * @return mixed
     */
    private function _lastMatchRugby()
    {
        if ($this->_rugbyIsEnable()) {
            return Match::where('statut', '!=', 'planifiee')->whereDate('date', '<', Carbon::now())->orderBy('date', 'DESC')->first();
        }
    }

    /**
     * @return mixed
     */
    private function _nextMatchRugby()
    {
        if ($this->_rugbyIsEnable()) {
            return Match::where('statut', '=', 'planifiee')->orderBy('date', 'ASC')->first();
        }
    }

    /**
     * @return string
     */
    private function _getRugbyName()
    {
        return '';
    }
}
