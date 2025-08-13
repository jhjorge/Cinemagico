import { ref, computed, watch } from 'vue';
import { defineStore } from 'pinia';
import type { Movie } from '@/types/movie';
import { useToastStore } from "@/stores/toast";

export const useFavoritesStore = defineStore('favorites', () => {
  const _data = ref<Movie[]>([]);
  const toastStore = useToastStore();
  const getItems = computed(() => _data.value);
  const count = computed(() => _data.value.length);
  const STORAGE_KEY = 'favorites';


  const readStorage = () => {
    const stored = localStorage.getItem(STORAGE_KEY);
    if (stored) {
      try {
        _data.value = JSON.parse(stored);
      } catch {
        _data.value = [];
      }
    }
  };
  watch(
    _data,
    (newVal) => {
      localStorage.setItem(STORAGE_KEY, JSON.stringify(newVal));

    },
    { deep: true }
  );


  const toggleItem = (movie: Movie) => {
    if (_data.value.some((m) => m.id === movie.id)) {
      _data.value = _data.value.filter((m) => m.id !== movie.id);
      toastStore.addToast({
        type: 'warning',
        message: `Removido dos favoritos: ${movie.title}`,
      });

      return
    }
    _data.value.push(movie);
    toastStore.addToast({
      type: 'success',
      message: `Adicionado aos favoritos: ${movie.title}`,
    });

  };

  const isFavorite = (id: number) => {
    return _data.value.some((m) => m.id === id);
  };
  readStorage();
  return {
    getItems,
    count,
    toggleItem,
    isFavorite,

  };

});
