export interface Movie {
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
export type MovieCategory = "popular" | "now_playing" | "top_rated" | "upcoming";

export interface Genre {
    id: number;
    name: string;
}