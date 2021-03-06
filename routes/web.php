<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'HomeController@show')->name('home');

Route::get('/carburants.html', 'GazController@show')->name('gazs');
Route::get('/silex.html', 'SilexController@show')->name('silex');

Route::get('images/pollutants/gauges', 'PollutantController@gauges')->name('pollutants_gauges');

Route::get('trains/{name}-{numero}.html', function ($name, $numero) {
})->name('details.train');
