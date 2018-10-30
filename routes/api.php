<?php

require_once __DIR__ . '/api/events.php';
require_once __DIR__ . '/api/pollutants.php';

Route::get('/weather', 'WeatherController@api')->name('api.weather');
