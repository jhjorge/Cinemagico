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
