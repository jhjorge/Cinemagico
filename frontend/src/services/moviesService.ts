import api from "@/services/api";
import type { GenreApiResponse, MovieApiResponse } from "@/types/api";

export const getGenresMovies = async (): Promise<GenreApiResponse> => {
    const response = await api.get("/movies/genres");
    return response.data;
};
export const getPopularMovies = async (page: number): Promise<MovieApiResponse> => {
    const response = await api.get("/movies/popular", { params: { page } });
    return response.data;
};

export const getNowPlayingMovies = async (page: number): Promise<MovieApiResponse> => {
    const response = await api.get("/movies/now-playing", { params: { page } });
    return response.data;
};

export const getTopRatedMovies = async (page: number): Promise<MovieApiResponse> => {
    const response = await api.get("/movies/top-rated", { params: { page } });
    return response.data;
};

export const getUpcomingMovies = async (page: number): Promise<MovieApiResponse> => {
    const response = await api.get("/movies/upcoming", { params: { page } });
    return response.data;
};
export const searchMovies = async (query: string, page: number): Promise<MovieApiResponse> => {
    const response = await api.get("/movies/search", { params: { query, page } });
    return response.data;
};
