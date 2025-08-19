<?php

namespace App\Swagger\Schemas;

/**
 * @OA\Schema(
 *     schema="Movie",
 *     description="Objeto representando um filme retornado pela API do TMDB",
 *     type="object",
 *     @OA\Property(property="adult", type="boolean", example=false, description="Indica se o filme é adulto"),
 *     @OA\Property(property="backdrop_path", type="string", example="/kyqM6padQzZ1eYxv84i9smNvZAG.jpg", description="Caminho da imagem de fundo"),
 *     @OA\Property(
 *         property="genre_ids",
 *         type="array",
 *         description="IDs dos gêneros do filme",
 *         @OA\Items(type="integer", example=27)
 *     ),
 *     @OA\Property(property="id", type="integer", example=1078605, description="ID do filme"),
 *     @OA\Property(property="original_language", type="string", example="en", description="Idioma original do filme"),
 *     @OA\Property(property="original_title", type="string", example="Weapons", description="Título original do filme"),
 *     @OA\Property(
 *         property="overview",
 *         type="string",
 *         example="Quando todas as crianças de uma mesma classe - exceto uma – somem misteriosamente na mesma noite e exatamente ao mesmo tempo, todos da cidade começam a se questionar quem ou o que está por trás deste estranho desaparecimento.",
 *         description="Resumo do filme"
 *     ),
 *     @OA\Property(property="popularity", type="number", format="float", example=201.3663, description="Popularidade do filme"),
 *     @OA\Property(property="poster_path", type="string", example="/psEJSjQr6I9GSJTdW28CKC4Kffs.jpg", description="Caminho da imagem do poster"),
 *     @OA\Property(property="release_date", type="string", format="date", example="2025-08-04", description="Data de lançamento"),
 *     @OA\Property(property="title", type="string", example="A Hora do Mal", description="Título do filme"),
 *     @OA\Property(property="video", type="boolean", example=false, description="Indica se possui vídeo"),
 *     @OA\Property(property="vote_average", type="number", format="float", example=7.555, description="Média das avaliações"),
 *     @OA\Property(property="vote_count", type="integer", example=442, description="Número de votos")
 * )
 *
 * @OA\Schema(
 *     schema="ApiMoviesResponse",
 *     description="Resposta da API contendo lista de filmes paginada",
 *     type="object",
 *     @OA\Property(property="page", type="integer", example=1, description="Página atual"),
 *     @OA\Property(
 *         property="results",
 *         type="array",
 *         description="Lista de filmes",
 *         @OA\Items(ref="#/components/schemas/Movie")
 *     ),
 *     @OA\Property(property="total_pages", type="integer", example=52003, description="Total de páginas disponíveis"),
 *     @OA\Property(property="total_results", type="integer", example=1040048, description="Total de filmes encontrados")
 * )
 *
 * @OA\Schema(
 *     schema="Genre",
 *     description="Objeto representando um gênero de filme",
 *     type="object",
 *     @OA\Property(property="id", type="integer", example=28, description="ID do gênero"),
 *     @OA\Property(property="name", type="string", example="Action", description="Nome do gênero")
 * )
 */
class MovieSchemas {}
