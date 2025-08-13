<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class MoviesControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Cache::flush();
    }

    public function test_get_popular_movies_success()
    {
        // Fake da resposta da API TMDB
        Http::fake([
            'https://api.themoviedb.org/3/movie/popular*' => Http::response([
                'results' => [
                    ['title' => 'Filme A', 'release_date' => '2023-06-01'],
                    ['title' => 'Filme B', 'release_date' => '2023-05-01'],
                ],
            ], 200),
        ]);

        $response = $this->getJson('/api/v1/movies/popular?page=1');

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'data' => [
                    'results' => [
                        ['title' => 'Filme A', 'release_date' => '2023-06-01'],
                        ['title' => 'Filme B', 'release_date' => '2023-05-01'],
                    ],
                ],
            ]);
    }

    public function test_search_movies_error()
    {
        $response = $this->getJson('/api/v1/movies/search');

        $response->assertStatus(422)
            ->assertJson([
                'status' => 'error',
                'message' => 'É necessária uma consulta para a pesquisa.',
            ]);
    }

    public function test_search_movies_success()
    {
        Http::fake([
            'https://api.themoviedb.org/3/search/movie*' => Http::response([
                'results' => [
                    ['title' => 'Filme Busca 1', 'release_date' => '2023-01-01'],
                ],
            ], 200),
        ]);

        $response = $this->getJson('/api/v1/movies/search?query=test&page=1');

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'data' => [
                    'results' => [
                        ['title' => 'Filme Busca 1', 'release_date' => '2023-01-01'],
                    ],
                ],
            ]);
    }

    public function test_get_genres_success()
    {
        Http::fake([
            'https://api.themoviedb.org/3/genre/movie/list*' => Http::response([
                'genres' => [
                    ['id' => 1, 'name' => 'Ação'],
                    ['id' => 2, 'name' => 'Comédia'],
                ],
            ], 200),
        ]);

        $response = $this->getJson('/api/v1/movies/genres');

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'data' => [
                    ['id' => 1, 'name' => 'Ação'],
                    ['id' => 2, 'name' => 'Comédia'],
                ],
            ]);
    }
}
