<?php

namespace Tests\Unit;

use App\Services\MoviesService;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class MoviesServiceTest extends TestCase
{
    protected MoviesService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new MoviesService();
    }

    public function test_getPopularMovies()
    {
        Http::fake([
            'https://api.themoviedb.org/3/movie/popular*' => Http::response([
                'results' => [
                    ['title' => 'Filme C', 'release_date' => '2023-04-01'],
                    ['title' => 'Filme A', 'release_date' => '2023-06-01'],
                    ['title' => 'Filme B', 'release_date' => ''],  // Vai ser filtrado
                ],
            ], 200),
        ]);

        $result = $this->service->getPopularMovies(1);

        $this->assertArrayHasKey('results', $result);
        $this->assertCount(2, $result['results']); // O filme sem release_date foi removido

        // Verifica que está ordenado por release_date desc
        $this->assertEquals('Filme A', $result['results'][0]['title']);
        $this->assertEquals('Filme C', $result['results'][1]['title']);
    }

    public function test_getNowPlayingMovies()
    {
        Http::fake([
            'https://api.themoviedb.org/3/movie/now_playing*' => Http::response([
                'results' => [
                    ['title' => 'Filme X', 'release_date' => '2023-02-01'],
                    ['title' => 'Filme Y', 'release_date' => '2023-03-01'],
                    ['title' => 'Filme Z', 'release_date' => null],
                ],
            ], 200),
        ]);

        $result = $this->service->getNowPlayingMovies(1);

        $this->assertArrayHasKey('results', $result);
        $this->assertCount(2, $result['results']);

        $this->assertEquals('Filme Y', $result['results'][0]['title']);
        $this->assertEquals('Filme X', $result['results'][1]['title']);
    }

    public function test_getTopRatedMovies()
    {
        Http::fake([
            'https://api.themoviedb.org/3/movie/top_rated*' => Http::response([
                'results' => [
                    ['title' => 'Filme 1', 'release_date' => '2023-07-01'],
                    ['title' => 'Filme 2', 'release_date' => ''],
                    ['title' => 'Filme 3', 'release_date' => '2023-05-01'],
                ],
            ], 200),
        ]);

        $result = $this->service->getTopRatedMovies(1);

        $this->assertArrayHasKey('results', $result);
        $this->assertCount(2, $result['results']);

        $this->assertEquals('Filme 1', $result['results'][0]['title']);
        $this->assertEquals('Filme 3', $result['results'][1]['title']);
    }

    public function test_getUpcomingMovies()
    {
        Http::fake([
            'https://api.themoviedb.org/3/movie/upcoming*' => Http::response([
                'results' => [
                    ['title' => 'Filme Alfa', 'release_date' => '2023-09-01'],
                    ['title' => 'Filme Beta', 'release_date' => null],
                    ['title' => 'Filme Gama', 'release_date' => '2023-08-01'],
                ],
            ], 200),
        ]);

        $result = $this->service->getUpcomingMovies(1);

        $this->assertArrayHasKey('results', $result);
        $this->assertCount(2, $result['results']);

        $this->assertEquals('Filme Alfa', $result['results'][0]['title']);
        $this->assertEquals('Filme Gama', $result['results'][1]['title']);
    }
}
