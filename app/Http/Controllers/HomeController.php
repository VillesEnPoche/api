<?php

namespace App\Http\Controllers;

use App\Models\Ter;
use App\Traits\Football;
use App\Traits\Rugby;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    use Football, Rugby;

    public function show(Request $request)
    {
        return view('pages.home', [
            'last_match' => $this->_lastMatch(),
            'next_match' => $this->_nextMatch(),
            'last_match_rugby' => $this->_lastMatchRugby(),
            'next_match_rugby' => $this->_nextMatchRugby(),
            'rugby_name' => $this->_getRugbyName(),
            'trains' => [
                'departures' => Ter::departures(),
                'arrivals' => Ter::arrivals(),
            ],
        ]);
    }
}
