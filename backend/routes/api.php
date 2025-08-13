<?php

use App\Http\Controllers\MoviesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->middleware('throttle:60,1')->group(function () {
    Route::get('movies/popular', [MoviesController::class, 'getPopular']);
    Route::get('movies/now-playing', [MoviesController::class, 'getNowPlaying']);
    Route::get('movies/top-rated', [MoviesController::class, 'getTopRated']);
    Route::get('movies/upcoming', [MoviesController::class, 'getUpcoming']);
    Route::get('movies/search', [MoviesController::class, 'search']);
    Route::get('movies/genres', [MoviesController::class, 'getGenres']);
});
