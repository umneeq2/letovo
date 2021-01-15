<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('api')->namespace('\App\Http\Controllers\Api')->group(function () {
    Route::resource('pupils', 'PupilsController')
        ->except(['create', 'edit']);

    Route::post('/pupils/normalize/{pupil}', 'PupilsController@normalize')
        ->name('pupils.normalize');
});
