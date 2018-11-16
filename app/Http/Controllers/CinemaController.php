<?php

namespace App\Http\Controllers;

use App\Interfaces\Silex;
use App\Models\Theaters\Movie;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CinemaController extends Controller implements Silex
{
    public function show(Request $request)
    {
        $movies = Movie::join('theaters_movies_times', 'theaters_movies_times.movie_id', '=', 'theaters_movies.id')
            ->where('theaters_movies_times.date', '>', Carbon::now())
            ->groupBy('theaters_movies_times.movie_id')
            ->orderBy('theaters_movies_times.date', 'asc')
            ->get();

        return view('pages.cinema', ['movies' => $movies, 'color' => 'blue']);
    }
}