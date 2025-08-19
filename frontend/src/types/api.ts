import type { Genre, Movie } from "@/types/movie";

export interface MovieApiResponse {
    status: string;
    data: {
        page: number,
        results: Movie[]
        total_pages: number
        total_results: number
    };
}
export interface GenreApiResponse {
    status: string;
    data: Genre[];
}
export interface MovieDetailResponse {
    id: number;
    title: string;
    original_title: string;
    overview: string;
    poster_path: string | null;
    backdrop_path: string | null;
    release_date: string;
    genre_ids: number[];
    vote_average: number;
    vote_count: number;
    popularity: number;
    original_language: string;
    adult: boolean;
    video: boolean;
}