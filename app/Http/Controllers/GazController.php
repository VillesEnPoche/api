<?php

namespace App\Http\Controllers;

use App\Models\Gas\Station;
use Illuminate\Http\Request;

class GazController extends Controller
{
    public function show(Request $request)
    {
        $stations = Station::all();

        return view('pages.gazs', ['stations' => $stations, 'color' => 'purple']);
    }
}
