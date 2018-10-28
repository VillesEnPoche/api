<?php

namespace App\Http\Controllers;

use App\Traits\Football;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    use Football;

    public function show(Request $request)
    {
        return view('pages.home', ['last_match' => $this->_lastMatch(), 'next_match' => $this->_nextMatch()]);
    }
}
