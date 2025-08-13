<script setup lang="ts">
import { onMounted, computed, ref } from "vue";
import MovieCard from "@/components/ui/MovieCard.vue";
import { useFavoritesStore } from "@/stores/favorites";
import { useMovieFetcher } from "@/services/fetchMovie";
import type { Genre } from "@/types/movie";
import PrimaryButton from "@/components/ui/buttons/PrimaryButton.vue";
import SkeletonButton from "@/components/ui/buttons/SkeletonButton.vue";

const favoritesStore = useFavoritesStore();
const { genres, getGenres, loading } = useMovieFetcher();

const selectedGenreId = ref<number | null>(null);

onMounted(() => {
  getGenres();
});

const allFavorites = computed(() => favoritesStore.getItems);

const filteredFavorites = computed(() => {
  if (!selectedGenreId.value) return allFavorites.value;
  return allFavorites.value.filter((movie) =>
    movie.genre_ids?.includes(selectedGenreId.value!)
  );
});
</script>

<template>
  <div class="container mx-auto">
    <h1 class="text-white text-5xl font-semibold m-4">Meus Favoritos</h1>
  </div>
  <section class="container mx-auto">
    <div class="flex gap-4 justify-center flex-wrap mx-1 sm:m-4" v-if="loading">
      <SkeletonButton v-for="i in 5" />
    </div>
    <div v-else>
      <h2 class="text-white text-2xl font-semibold m-4">Filtros por Gêneros</h2>

      <div
        class="flex snap-x snap-always gap-4 m-4 pb-6 overflow-hidden overflow-x-auto scrollbar-custom"
      >
        <PrimaryButton
          @click="selectedGenreId = null"
          :disabled="selectedGenreId === null"
          :class="[
            ' rounded text-sm font-medium border hover:bg-[var(--color-secondary)] hover:text-black snap-start',
            selectedGenreId === null
              ? 'bg-[var(--color-secondary)] bg-opacity-70 text-black cursor-not-allowed'
              : 'text-white hover:bg-[var(--color-secondary)] hover:text-black cursor-pointer',
          ]"
        >
          Todos
        </PrimaryButton>

        <PrimaryButton
          v-for="genre in genres"
          :key="genre.id"
          :disabled="selectedGenreId === genre.id"
          @click="selectedGenreId = genre.id"
          :class="[
            'hover:bg-[var(--color-secondary)] hover:text-black snap-start',
            selectedGenreId === genre.id
              ? ' bg-[var(--color-secondary)] bg-opacity-70 text-black cursor-not-allowed'
              : 'text-white hover:bg-[var(--color-secondary)] hover:text-black cursor-pointer',
          ]"
        >
          {{ genre.name }}
        </PrimaryButton>
      </div>
    </div>
  </section>
  <section class="container mx-auto py-6 px-4 min-h-[75dvh] h-full">
    <div v-if="filteredFavorites.length > 0">
      <div
        class="grid p-6 grid-cols-[repeat(auto-fit,minmax(200px,1fr))] sm:grid-cols-[repeat(auto-fit,minmax(280px,1fr))] gap-8 card-container"
      >
        <MovieCard
          v-for="movie in filteredFavorites"
          :key="movie.id"
          :movie="movie"
          class="card"
        />
      </div>
    </div>

    <div
      v-else
      class="text-center place-content-center font-medium text-2xl text-white min-h-[68dvh]"
    >
      <p>Nenhum conteúdo encontrado nos favoritos 😢</p>
    </div>
  </section>
</template>

<style scoped lang="scss">
.card-container:has(.card:hover) .card:not(:hover) {
  opacity: 0.9;
  transform: scale(0.95);
}
.card {
  transition: all 0.3s ease-in-out;
}
.scrollbar-custom::-webkit-scrollbar {
  height: 12px;
}

.scrollbar-custom::-webkit-scrollbar-track {
  background: transparent;
}

.scrollbar-custom::-webkit-scrollbar-thumb {
  background-color: var(--color-secondary);
  border-radius: 24px;
}
</style>
