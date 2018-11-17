<?php

namespace App\Http\Controllers;

use App\Models\Ter;
use App\Models\Ters\Alert;
use App\Traits\Football;
use App\Traits\Rugby;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    use Football, Rugby;

    public function show(Request $request)
    {
        $city = trans('preposition.' . substr(strtolower(env('APP_CITY')), 0, 1)) . env('APP_CITY');

        return view('pages.home', [
            'city' => $city,
            'last_match' => $this->_lastMatch(),
            'next_match' => $this->_nextMatch(),
            'last_match_rugby' => $this->_lastMatchRugby(),
            'next_match_rugby' => $this->_nextMatchRugby(),
            'rugby_name' => $this->_getRugbyName(),
            'trains' => [
                'departures' => Ter::departures(),
                'arrivals' => Ter::arrivals(),
            ],
            'trains_alerts' => Alert::today(),
        ]);
    }
}
