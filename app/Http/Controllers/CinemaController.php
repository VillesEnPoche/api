<?php

namespace App\Http\Controllers;

use App\Interfaces\Silex;
use App\Models\Theaters\Movie;
use App\Models\Theaters\Movies\Time;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CinemaController extends Controller implements Silex
{
    public function show(Request $request)
    {
        $movies = Movie::select(['theaters_movies.*', 'theaters_movies_times.date'])
            ->join('theaters_movies_times', 'theaters_movies_times.movie_id', '=', 'theaters_movies.id')
            ->where('theaters_movies_times.date', '>=', Carbon::now())
            ->groupBy('theaters_movies_times.movie_id')
            ->orderBy('theaters_movies_times.date', 'asc')
            ->get();

        return view('pages.cinema', ['movies' => $movies, 'color' => 'blue']);
    }

    public function movie(Request $request)
    {
        $movie = Movie::find($request->route('id'));

        $times = Time::where('movie_id', '=', $request->route('id'))
            ->whereDate('date', '>=', Carbon::now())
            ->orderBy('date', 'asc')
            ->get();

        // Regroupement
        $regroupement = [];
        foreach ($times as $time) {
            $regroupement[$time->date->format('Y-m-d')][] = $time;
        }

        return view('pages.cinema.movie', ['movie' => $movie, 'sessions' => $regroupement, 'color' => 'blue']);
    }
}
