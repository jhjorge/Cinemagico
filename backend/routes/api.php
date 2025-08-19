<?php

use App\Http\Controllers\MoviesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('v1/movies')->middleware('throttle:60,1')->group(function () {
    Route::get('/popular', [MoviesController::class, 'getPopular']);
    Route::get('/now-playing', [MoviesController::class, 'getNowPlaying']);
    Route::get('/top-rated', [MoviesController::class, 'getTopRated']);
    Route::get('/upcoming', [MoviesController::class, 'getUpcoming']);
    Route::get('/search', [MoviesController::class, 'search']);
    Route::get('/genres', [MoviesController::class, 'getGenres']);
    Route::get('/{id}', [MoviesController::class, 'getDetail']);
});
