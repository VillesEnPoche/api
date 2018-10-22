<?php

use Illuminate\Http\Request;

require_once __DIR__ . '/api/pollutants.php';

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
