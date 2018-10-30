<?php

use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Http\Request;

/**
 * Routes sur les polluants de l'air.
 */
Route::prefix('events')->group(function () {
    Route::get('/', function (Request $request) {

        // Début de tranche
        $start = new DateTime();
        if (! is_null($request->query('start')) && preg_match('#^20[1-3][0-9][0-1][0-9][0-3][0-9]$#', $request->query('start')) === 1) {
            $start = Carbon::createFromFormat('Ymd', $request->query('start'));
        }
        $events = Event::where('start', '>=', $start);

        if (! is_null($request->query('place_id'))) {
            $events = $events->where('place_id', '=', intval($request->query('place_id')));
        }

        // Fin de tranche
        if (! is_null($request->query('end')) && preg_match('#^20[1-3][0-9][0-1][0-9][0-3][0-9]$#', $request->query('end')) === 1) {
            $end = Carbon::createFromFormat('Ymd', $request->query('end'));
            $events = $events->whereDate('end', '<=', $end);
        }

        return response()->json($events->get());
    });

    Route::get('/{id}', function ($id) {
        return response()->json(Event::find($id));
    })->where('id', '[0-9]+');
});
