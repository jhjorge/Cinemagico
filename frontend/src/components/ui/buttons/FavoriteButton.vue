<script setup lang="ts">
import { computed } from "vue";
import { useFavoritesStore } from "@/stores/favorites";

defineProps<{
  count?: boolean;
  small?: boolean;
}>();

const favoritesStore = useFavoritesStore();

const count = computed(() => favoritesStore.count);
</script>

<template>
  <button
    class="inline-flex items-center gap-1 px-3 py-1.5 rounded-xl bg-[var(--color-third)] shadow-sm shadow-white/30 text-white hover:scale-105 text-sm font-medium transition-all ease-in group relative"
    :class="{ 'text-sm': small, 'text-base': !small }"
  >
    <span
      class="material-symbols-outlined text-[20px] text-red-500 group-hover:animate-bounce transition-all ease-in-out duration-300"
      :style="{ WebkitTextStroke: '0.3px #fff' }"
      >favorite</span
    >
    <span><slot class="hidden md:inline" /></span>

    <span
      v-if="count && count > 0"
      class="absolute -top-2 -right-2 ml-1 inline-flex items-center justify-center text-xs font-bold text-white bg-red-700 rounded-full size-5"
    >
      {{ count }}
    </span>
  </button>
</template>
