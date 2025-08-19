export interface Movie {
    id: number;
    title: string;
    original_title: string;
    overview: string;
    poster_path: string | null;
    backdrop_path: string | null;
    release_date: string;
    genre_ids?: number[];
    genres?: Genre[];
    vote_average: number;
    vote_count: number;
    popularity: number;
    original_language: string;
    adult: boolean;
    video: boolean;
    runtime?: number;
    status?: string;
    production_companies?: { id: number; name: string; logo_path: string | null; origin_country: string }[];
    production_countries?: { iso_3166_1: string; name: string }[];
    spoken_languages?: { iso_639_1: string; english_name: string; name: string }[];
    homepage?: string;
    tagline?: string;
}

export type MovieCategory = "popular" | "now_playing" | "top_rated" | "upcoming";

export interface Genre {
    id: number;
    name: string;
}