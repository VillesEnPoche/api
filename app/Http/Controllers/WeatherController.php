<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class WeatherController extends Controller
{
    public function api(Request $request)
    {
        return Cache::remember('weather_sd', env('WEATHER_CACHE', 10), function () {
            $json = file_get_contents('https://api.openweathermap.org/data/2.5/forecast?lat=' . env('LATITUDE') . '&lon=' . env('LONGITUDE') . '&units=metric&lang=fr&appid=' . env('WEATHER_API'));
            $json = json_decode($json, true);

            return response()->json($json);
        });
    }
}
