<?php

namespace App\Http\Controllers;

use App\Http\Requests\MovieRequest;
use App\Services\MoviesService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class MoviesController extends Controller
{
    private \DateTimeInterface $ttl;
    public function __construct(private MoviesService $movies_service)
    {
        $this->ttl = now()->addMinutes(30);
    }

    public function getGenres()
    {
        $cacheKey = "tmdb_genres";

        $genres = Cache::remember($cacheKey, $this->ttl, function () {
            return $this->movies_service->getGenre();
        });

        return response()->json([
            'status' => 'success',
            'data' => $genres,
        ], 200);
    }
    public function getPopular(MovieRequest $request)
    {
        $page = $request->query('page', 1);
        $cacheKey = "popular_movies_page_{$page}";
        $movies = Cache::remember($cacheKey, $this->ttl, function () use ($page) {
            return $this->movies_service->getPopularMovies($page);
        });

        return response()->json([
            'status' => 'success',
            'data' => $movies ?? [],
        ], 200);
    }

    public function search(MovieRequest $request)
    {
        $query = $request->query('query');
        $page = $request->query('page', 1);


        if (!$query) {
            return response()->json([
                'status' => 'error',
                'message' => 'É necessária uma consulta para a pesquisa.',
            ], 422);
        }

        $movies = $this->movies_service->searchMovies($query, $page);

        return response()->json([
            'status' => 'success',
            'data' => $movies ?? [],
        ], 200);
    }

    public function getNowPlaying(MovieRequest $request)
    {
        $page = $request->query('page', 1);
        $cacheKey = "getnowplaying_movies_page_{$page}";
        $movies = Cache::remember($cacheKey, $this->ttl, function () use ($page) {
            return $this->movies_service->getNowPlayingMovies($page);
        });

        return response()->json(['status' => 'success', 'data' => $movies], 200);
    }

    public function getTopRated(MovieRequest $request)
    {
        $page = $request->query('page', 1);
        $cacheKey = "gettoprated_movies_page_{$page}";
        $movies = Cache::remember($cacheKey, $this->ttl, function () use ($page) {
            return $this->movies_service->getTopRatedMovies($page);
        });


        return response()->json(['status' => 'success', 'data' => $movies], 200);
    }

    public function getUpcoming(MovieRequest $request)
    {
        $page = $request->query('page', 1);
        $cacheKey = "getupcoming_movies_page_{$page}";
        $movies = Cache::remember($cacheKey, $this->ttl, function () use ($page) {
            return $this->movies_service->getUpcomingMovies($page);
        });


        return response()->json(['status' => 'success', 'data' => $movies], 200);
    }
}
