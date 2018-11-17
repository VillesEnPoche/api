<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RobotsController extends Controller
{
    /**
     * Gère le robots.txt en fonction de la prod ou debug.
     *
     * @param Request $request
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function get(Request $request)
    {
        $robots = 'User-agent: *
Disallow:';

        if (env('APP_DEBUG')) {
            $robots .= ' /';
        }

        return response($robots, 200)
            ->header('Content-Type', 'text/plain');
    }
}
