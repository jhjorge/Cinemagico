import { ref } from "vue";
import {
    getPopularMovies,
    getNowPlayingMovies,
    getTopRatedMovies,
    getUpcomingMovies,
    searchMovies,
    getGenresMovies,
} from "@/services/moviesService";
import type { Genre, Movie, MovieCategory } from "@/types/movie";



const fetchMap = {
    popular: getPopularMovies,
    now_playing: getNowPlayingMovies,
    top_rated: getTopRatedMovies,
    upcoming: getUpcomingMovies,
};

export function useMovieFetcher() {
    const movies = ref<Movie[]>([]);
    const genres = ref<Genre[]>([]);
    const loading = ref(false);
    const currentPage = ref(1);
    const totalPages = ref(1);
    const currentCategory = ref<MovieCategory>("popular");

    const fetchMovies = async (page = 1) => {
        loading.value = true;
        try {
            const fetchFunction = fetchMap[currentCategory.value];
            const res = await fetchFunction(page);
            movies.value = res.data.results;
            currentPage.value = res.data.page;
            totalPages.value = res.data.total_pages;
        } catch (err) {
            console.error("Erro ao buscar filmes:", err);
        } finally {
            loading.value = false;
        }
    };

    const changeCategory = (category: MovieCategory) => {
        if (currentCategory.value === category) return;
        currentCategory.value = category;
        currentPage.value = 1;
        fetchMovies();
    };

    const searchFunction = async (query: string, page: number = 1) => {
        loading.value = true;
        try {
            const res = await searchMovies(query, page)
            movies.value = res.data.results;
            currentPage.value = res.data.page;
            totalPages.value = res.data.total_pages;
        } catch (err) {
            console.error("Erro ao buscar filmes:", err);
        } finally {
            loading.value = false;
        }
    }
    const getGenres = async () => {
        loading.value = true;
        try {
            const res = await getGenresMovies();
            genres.value = res.data;
        } catch (err) {
            console.error("Erro ao buscar gêneros:", err);
        } finally {
            loading.value = false;
        }
    };


    return {
        movies,
        loading,
        genres,
        searchFunction,
        currentPage,
        totalPages,
        currentCategory,
        fetchMovies,
        changeCategory,
        getGenres,
    };
}
