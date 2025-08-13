<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Throwable;

class MoviesService
{
    protected $baseUrl;
    protected $apiKey;

    public function __construct()
    {
        $this->apiKey = env('TMDB_API_KEY');
        $this->baseUrl = env('TMDB_BASE_URL');
    }

    /**
     * Loga o resultado da requisição
     *
     * @param string $endpoint
     * @param array $params
     * @param mixed $response
     * @param bool $success
     */
    private function logRegister(string $endpoint, array $params, $response, bool $success): void
    {
        if (env('LOG_MOVIES', false)) {
            $status = $success ? 'SUCESSO' : 'ERRO';

            Log::channel('movies')->debug("[$status] Requisição TMDB", [
                'endpoint' => $endpoint,
                'params'   => $params,
                'response' => $response
            ]);
        }
    }

    protected function request(string $endpoint, array $params = [])
    {
        $params['api_key'] = $this->apiKey;
        $params['language'] = 'pt-BR';
        try {
            $response = Http::get("{$this->baseUrl}{$endpoint}", $params);
            $data = $response->json();

            $this->logRegister($endpoint, $params, $data, $response->successful());

            return $data;
        } catch (\Throwable $e) {
            $this->logRegister($endpoint, $params, $e->getMessage(), false);
            return [];
        }
    }


    public function searchMovies(string $query, int $page = 1)
    {
        return $this->request('/search/movie', [
            'query' => $query,
            'page' => $page,
        ]);
    }

    public function getGenre()
    {
        $result = $this->request('/genre/movie/list');
        return $result['genres'] ?? [];
    }

    public function getPopularMovies(int $page = 1)
    {
        $result = $this->request('/movie/popular', ['page' => $page]);
        return $this->filterMovies($result);
    }

    public function getNowPlayingMovies(int $page = 1)
    {
        $result = $this->request('/movie/now_playing', ['page' => $page]);
        return $this->filterMovies($result);
    }

    public function getTopRatedMovies(int $page = 1)
    {
        $result = $this->request('/movie/top_rated', ['page' => $page]);
        return $this->filterMovies($result);
    }

    public function getUpcomingMovies(int $page = 1)
    {
        $result = $this->request('/movie/upcoming', ['page' => $page]);
        return $this->filterMovies($result);
    }


    private function filterMovies($result)
    {
        if (!isset($result['results'])) {
            return [];
        }

        $movies = collect($result['results'])
            ->filter(fn($movie) => !empty($movie['release_date']))
            ->sortByDesc('release_date')
            ->values();

        $result['results'] = $movies->all();
        return $result;
    }
}
