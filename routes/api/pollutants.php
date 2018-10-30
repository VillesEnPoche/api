<?php

use App\Http\Resources\PollutantCollection;
use App\Http\Resources\PollutantResource;
use App\Models\Pollutant;
use App\Models\Pollutants\History;
use Illuminate\Http\Resources\Json\ResourceCollection;

/**
 * Routes sur les polluants de l'air.
 */
Route::prefix('pollutants')->group(function () {
    Route::get('/', function () {
        return new PollutantCollection(Pollutant::all());
    });

    Route::get('/{id}', function ($id) {
        return new PollutantResource(Pollutant::find($id));
    })->where('id', '[0-9]+');

    /**
     * Routes de l'historique.
     */
    Route::prefix('histories')->group(function () {
        Route::get('/{date}/{type?}', function ($date, $type = null) {
            $histories = History::whereDate('date', '=', $date);
            if (! is_null($type) && in_array($type, ['analyse', 'prevision'])) {
                $histories = $histories->where('type', '=', $type);
            }

            return new ResourceCollection($histories->get());
        })->where('date', '20([0-9]{6})');
    });
});
