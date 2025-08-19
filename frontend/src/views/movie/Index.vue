<script setup lang="ts">
import { ref, onMounted, computed } from "vue";
import { useRoute } from "vue-router";
import { getMovieById } from "@/services/moviesService";
import type { Movie } from "@/types/movie";
import PrimaryButton from "@/components/ui/buttons/PrimaryButton.vue";
import SkeletonMovie from "@/components/ui/SkeletonMovie.vue";
const movie = ref<Movie>();
const loading = ref(true);
const error = ref();
const route = useRoute();

onMounted(async () => {
  try {
    const id = route.params.id as string;
    const response = await getMovieById(id);
    movie.value = response;
    if (movie.value?.title) {
      document.title = `${movie.value.title} - ${import.meta.env.VITE_APP_NAME}`;
    }
  } catch (e: unknown) {
    error.value = `Erro ao carregar detalhes do filme: ${e}`;
  } finally {
    loading.value = false;
  }
});
const backgroundImageStyle = computed(() => ({
  backgroundImage: movie.value?.backdrop_path
    ? `url('https://image.tmdb.org/t/p/original${movie.value.backdrop_path}')`
    : `url('/images/fallback.png')`,
}));
</script>
<template>
  <div class="min-h-[80vh] bg-[var(--color-third)] text-white">
    <div v-if="loading" class="text-center text-gray-400">
      <SkeletonMovie />
    </div>
    <div v-else-if="error" class="text-center py-20 text-red-500">
      {{ error }}
    </div>
    <div v-else-if="movie">
      <div
        class="w-full h-[60vh] md:h-[70vh] bg-center bg-cover relative"
        :style="backgroundImageStyle"
      >
        <div class="absolute inset-0 bg-[var(--color-third)]/60"></div>
        <div class="flex flex-col justify-end h-full p-6 container mx-auto z-10 relative">
          <h1 class="text-3xl md:text-5xl font-bold">{{ movie.title }}</h1>
          <p class="text-gray-300 mt-2">{{ movie.release_date }} | {{ movie.status }}</p>
          <div class="flex flex-wrap gap-2 mt-2">
            <span
              v-for="genre in movie.genres"
              :key="genre.id"
              class="bg-[var(--color-secondary)] text-black text-xs font-semibold px-2 py-1 rounded"
            >
              {{ genre.name }}
            </span>
          </div>
        </div>
      </div>

      <div class="container mx-auto p-6 space-y-6">
        <p class="text-gray-200 text-lg max-w-3xl">
          {{ movie.overview || "Sem descrição disponível." }}
        </p>

        <ul
          class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-gray-300 text-sm rounded-xl border p-2"
        >
          <li><strong>Titulo Original:</strong> {{ movie.original_title }}</li>
          <li>
            <strong>Idioma Original:</strong>
            {{ movie.original_language?.toUpperCase() ?? "N/A" }}
          </li>
          <li><strong>Runtime:</strong> {{ movie.runtime }} min</li>
          <li><strong>Popularidade:</strong> {{ movie.popularity?.toFixed(1) }}</li>
          <li>
            <strong>Nota:</strong> ⭐ {{ movie.vote_average?.toFixed(1) }} ({{
              movie.vote_count
            }}
            votos)
          </li>
          <li><strong>Status:</strong> {{ movie.status }}</li>
          <li>
            <strong>País de Produção:</strong>
            {{ movie.production_countries?.map((c) => c.name).join(", ") }}
          </li>
          <li>
            <strong>Produtoras:</strong>
            {{ movie.production_companies?.map((c) => c.name).join(", ") }}
          </li>
        </ul>

        <PrimaryButton v-if="movie.homepage" class="mt-4">
          <a :href="movie.homepage" target="_blank" class=""> Página oficial </a>
        </PrimaryButton>
      </div>
    </div>
  </div>
</template>
