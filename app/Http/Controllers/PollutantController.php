<?php

namespace App\Http\Controllers;

use App\Models\Pollutants\History;
use Illuminate\Http\Request;

class PollutantController extends Controller
{
    public function gauges(Request $request)
    {
        $date = History::select('date')->where('var', '=', 'MOYJ')
            ->where('type', '=', 'analyse')->orderBy('date', 'DESC')->first();

        $data = History::where('var', '=', 'MOYJ')
            ->where('type', '=', 'analyse')
            ->where('date', '=', $date->date)
            ->orderBy('date', 'DESC')
            ->orderBy('pollutant_id', 'ASC')
            ->get();

        return view('images.pollutant', ['data' => $data]);
    }
}
