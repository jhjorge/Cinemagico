<script setup lang="ts">
import { ref } from "vue";
import PrimaryButton from "./buttons/PrimaryButton.vue";
import type { Movie } from "@/types/movie";
import { useFavoritesStore } from "@/stores/favorites";

const props = defineProps<{
  movie: Movie;
}>();
const isActive = ref(false);
const store = useFavoritesStore();
</script>

<template>
  <article
    tabindex="0"
    role="button"
    @click="isActive = !isActive"
    @keyup.enter.space="isActive = !isActive"
    :aria-expanded="isActive"
    :aria-label="`Expandir detalhes do filme ${movie.title}`"
    class="max-w-sm rounded-2xl overflow-hidden transition-all shadow-md ring-white/10 ring-1 relative h-[66dvh] md:h-[50dvh] group focus:ring-3 focus:ring-[var(--color-primary)] hover:ring-[var(--color-primary)] card"
  >
    <img
      v-if="movie.poster_path"
      :src="`https://image.tmdb.org/t/p/w500${movie.poster_path}`"
      :alt="movie.title"
      class="w-full h-full absolute object-cover inset-0"
    />
    <div class="absolute top right-0 z-20 m-2">
      <span
        class="material-symbols-outlined cursor-pointer p-1 rounded-full drop-shadow-2xl transition-colors duration-500 ease-in-out"
        :class="
          store.isFavorite(movie.id)
            ? 'text-red-500 drop-shadow-2xl drop-shadow-white '
            : 'text-white hover:text-red-500'
        "
        :style="
          store.isFavorite(movie.id)
            ? { WebkitTextStroke: '0.5px #fff' }
            : { WebkitTextStroke: '0.5px #000' }
        "
        @click.stop="store.toggleItem(movie)"
      >
        favorite
      </span>
    </div>
    <div
      class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-transparent z-10"
    ></div>

    <footer
      :class="[isActive ? 'bg-gradient-to-t min-h-max' : '']"
      class="absolute bottom-0 z-20 p-4 flex flex-col text-white w-full group-hover:bg-gradient-to-t from-black/80 from-90% to-transparent transition-all ease-in-out duration-500"
    >
      <div class="drop-shadow-2xl">
        <h2 class="text-lg font-semibold line-clamp-2">{{ movie.title }}</h2>
        <p class="text-sm">{{ movie.release_date }}</p>
        <span class="text-yellow-300 font-semibold text-sm">
          ⭐ {{ movie.vote_average ? movie.vote_average.toFixed(1) : "N/A" }}
        </span>
      </div>

      <div class="md:hidden flex">
        <span
          aria-label="Clique para ver mais detalhes do filme"
          :class="[
            isActive ? 'rotate-180 translate-y-0' : 'animate-bounce translate-y-3 ',
          ]"
          class="mx-auto group-hover:rotate-180 transition duration-500 material-symbols-outlined rounded-full bg-black border-2 border-white p-1"
        >
          keyboard_double_arrow_down
        </span>
      </div>

      <div
        :class="[isActive ? 'opacity-100 h-auto' : '']"
        class="opacity-0 group-hover:opacity-100 group-hover:h-auto transition-all h-0 duration-500 ease-in-out space-y-4"
      >
        <p class="text-md line-clamp-3 leading-relaxed">
          {{ movie.overview ? movie.overview : "N/A" }}
        </p>

        <PrimaryButton
          :aria-label="`veja mais sobre ${movie.title}`"
          class="pointer-coarse:"
        >
          Veja mais
        </PrimaryButton>
      </div>
    </footer>
  </article>
</template>

<style scoped lang="scss">
.material-symbols-outlined {
  font-variation-settings: "FILL" 1, "wght" 400, "GRAD" 0, "opsz" 24;
}
</style>
