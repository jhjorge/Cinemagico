<?php

namespace App\Http\Controllers;

use App\Http\Requests\MovieRequest;
use App\Services\MoviesService;
use Illuminate\Support\Facades\Cache;


/**
 * @OA\Info(
 *     title="Cine Mágico API",
 *     version="1.0.0",
 *     description="Documentação da API do Cine Mágico - baseada no TMDB",
 *     @OA\Contact(email="jhjorgexs@gmail.com")
 * )
 *
 * @OA\Server(
 *     url="http://localhost:8000",
 *     description="Servidor local"
 * )
 *
 * @OA\Tag(
 *     name="Movies",
 *     description="Operações relacionadas a filmes"
 * )
 */
class MoviesController extends Controller
{
    private \DateTimeInterface $ttl;
    public function __construct(private MoviesService $movies_service)
    {
        $this->ttl = now()->addMinutes(30);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/movies/genres",
     *     tags={"Movies"},
     *     summary="Listar gêneros",
     *     description="Retorna a lista de gêneros disponíveis",
     *     @OA\Response(
     *         response=200,
     *         description="Lista de gêneros retornada com sucesso",
     *         @OA\JsonContent(
     *             allOf={
     *                 @OA\Schema(
     *                     @OA\Property(property="status", type="string", example="success"),
     *                     @OA\Property(
     *                         property="data",
     *                         type="array",
     *                         @OA\Items(ref="#/components/schemas/Genre")
     *                     )
     *                 )
     *             }
     *         )
     *     )
     * )
     */

    public function getGenres()
    {
        $cacheKey = "tmdb_genres";

        $genres = Cache::remember($cacheKey, $this->ttl, fn() =>  $this->movies_service->getGenre());

        return response()->json([
            'status' => 'success',
            'data' => $genres,
        ], 200);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/movies/{id}",
     *     tags={"Movies"},
     *     summary="Detalhes de um filme",
     *     description="Retorna os detalhes de um filme específico",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID do filme",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Detalhes do filme retornado com sucesso",
     *         @OA\JsonContent(
     *             allOf={
     *                 @OA\Schema(
     *                     @OA\Property(property="status", type="string", example="success"),
     *                     @OA\Property(property="data", ref="#/components/schemas/Movie")
     *                 )
     *             }
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Filme não encontrado",
     *         @OA\JsonContent(
     *             @OA\Schema(
     *                 @OA\Property(property="status", type="string", example="error"),
     *                 @OA\Property(property="message", type="string", example="Filme não encontrado")
     *             )
     *         )
     *     )
     * )
     */

    public function getDetail(int $id)
    {
        $movie = $this->movies_service->getMovieDetail($id);
        return response()->json($movie);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/movies/popular",
     *     tags={"Movies"},
     *     summary="Filmes populares",
     *     description="Retorna lista paginada de filmes populares",
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         required=false,
     *         description="Número da página",
     *         @OA\Schema(type="integer", default=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Lista de filmes populares retornada com sucesso",
     *         @OA\JsonContent(
     *             allOf={
     *                 @OA\Schema(
     *                     @OA\Property(property="status", type="string", example="success"),
     *                     @OA\Property(property="data", ref="#/components/schemas/ApiMoviesResponse")
     *                 )
     *             }
     *         )
     *     )
     * )
     */

    public function getPopular(MovieRequest $request)
    {
        $page = $request->query('page', 1);
        $cacheKey = "popular_movies_page_{$page}";
        $movies = Cache::remember($cacheKey, $this->ttl, fn() => $this->movies_service->getPopularMovies($page));

        return response()->json([
            'status' => 'success',
            'data' => $movies ?? [],
        ], 200);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/movies/search",
     *     tags={"Movies"},
     *     summary="Pesquisar filmes",
     *     description="Pesquisa filmes por título",
     *     @OA\Parameter(name="query", in="query", required=true, description="Texto da pesquisa", @OA\Schema(type="string")),
     *     @OA\Parameter(name="page", in="query", required=false, description="Número da página", @OA\Schema(type="integer", default=1)),
     *     @OA\Response(
     *         response=200,
     *         description="Lista de filmes encontrada",
     *         @OA\JsonContent(
     *             allOf={
     *                 @OA\Schema(
     *                     @OA\Property(property="status", type="string", example="success"),
     *                     @OA\Property(property="data", ref="#/components/schemas/ApiMoviesResponse")
     *                 )
     *             }
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Query não fornecida",
     *         @OA\JsonContent(
     *             @OA\Schema(
     *                 @OA\Property(property="status", type="string", example="error"),
     *                 @OA\Property(property="message", type="string", example="É necessária uma consulta para a pesquisa.")
     *             )
     *         )
     *     )
     * )
     */

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

    /**
     * @OA\Get(
     *     path="/api/v1/movies/now-playing",
     *     tags={"Movies"},
     *     summary="Filmes em cartaz",
     *     description="Retorna lista paginada de filmes em cartaz",
     *     @OA\Parameter(name="page", in="query", required=false, @OA\Schema(type="integer", default=1)),
     *     @OA\Response(response=200, description="Lista de filmes em cartaz retornada com sucesso", @OA\JsonContent(allOf={
     *         @OA\Schema(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="data", ref="#/components/schemas/ApiMoviesResponse")
     *         )
     *     }))
     * )
     */

    public function getNowPlaying(MovieRequest $request)
    {
        $page = $request->query('page', 1);
        $cacheKey = "getnowplaying_movies_page_{$page}";
        $movies = Cache::remember($cacheKey, $this->ttl, fn() => $this->movies_service->getNowPlayingMovies($page));

        return response()->json(['status' => 'success', 'data' => $movies], 200);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/movies/top-rated",
     *     tags={"Movies"},
     *     summary="Filmes mais bem avaliados",
     *     description="Retorna lista paginada de filmes mais bem avaliados",
     *     @OA\Response(response=200, description="Lista de filmes retornada com sucesso", @OA\JsonContent(allOf={
     *         @OA\Schema(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="data", ref="#/components/schemas/ApiMoviesResponse")
     *         )
     *     }))
     * )
     */

    public function getTopRated(MovieRequest $request)
    {
        $page = $request->query('page', 1);
        $cacheKey = "gettoprated_movies_page_{$page}";
        $movies = Cache::remember($cacheKey, $this->ttl, fn() => $this->movies_service->getTopRatedMovies($page));


        return response()->json(['status' => 'success', 'data' => $movies], 200);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/movies/upcoming",
     *     tags={"Movies"},
     *     summary="Próximos lançamentos",
     *     description="Retorna lista paginada de filmes que ainda serão lançados",
     *     @OA\Response(response=200, description="Lista de filmes futuros retornada com sucesso", @OA\JsonContent(allOf={
     *         @OA\Schema(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="data", ref="#/components/schemas/ApiMoviesResponse")
     *         )
     *     }))
     * )
     */

    public function getUpcoming(MovieRequest $request)
    {
        $page = $request->query('page', 1);
        $cacheKey = "getupcoming_movies_page_{$page}";
        $movies = Cache::remember($cacheKey, $this->ttl, fn() => $this->movies_service->getUpcomingMovies($page));


        return response()->json(['status' => 'success', 'data' => $movies], 200);
    }
}
