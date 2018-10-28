<?php

namespace App\Http\Controllers;

use App\Interfaces\Silex;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SilexController extends Controller implements Silex
{
    use \App\Traits\Silex;

    public function show(Request $request)
    {
        $events = $this->_getPlace()->events()->whereDate('start', '>', Carbon::now())->orderBy('start')->get();

        return view('pages.silex', ['events' => $events, 'color' => 'blue']);
    }
}
