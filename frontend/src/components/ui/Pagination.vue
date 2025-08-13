<script setup lang="ts">
import { computed, defineProps, defineEmits } from "vue";
const MAX_ALLOWED_PAGES = 500;
interface Props {
  currentPage: number;
  totalPages: number;
  maxVisible: number;
}

const props = defineProps<Props>();

const emit = defineEmits<{
  (e: "update:page", page: number): void;
}>();

const maxVisible = props.maxVisible ?? 10;

const visiblePages = computed(() => {
  const pages: (number | string)[] = [];
  const current = props.currentPage;
  const total = Math.min(props.totalPages, MAX_ALLOWED_PAGES);

  if (total <= maxVisible + 2) {
    for (let i = 1; i <= total; i++) pages.push(i);
  } else {
    pages.push(1);

    const start = Math.max(2, current - Math.floor(maxVisible / 2));
    const end = Math.min(total - 1, current + Math.floor(maxVisible / 2));

    if (start > 2) pages.push("...");
    for (let i = start; i <= end; i++) pages.push(i);
    if (end < total - 1) pages.push("...");

    pages.push(total);
  }

  return pages;
});

function selectPage(page: number) {
  const total = Math.min(props.totalPages, MAX_ALLOWED_PAGES);
  if (page !== props.currentPage && page >= 1 && page <= total) {
    emit("update:page", page);
  }
}
</script>

<template>
  <nav aria-label="Paginação do site" class="flex justify-center mt-6">
    <ul class="md:inline-flex flex flex-wrap -space-x-px text-sm">
      <li>
        <button
          :disabled="props.currentPage === 1"
          @click="selectPage(props.currentPage - 1)"
          :class="[
            'flex items-center justify-center px-4 h-10 ms-0 leading-tight border border-e-0 rounded-s-lg bg-gray-800 border-gray-700 text-gray-400 hover:bg-gray-700 hover:text-white',
            props.currentPage === 1 ? 'cursor-not-allowed' : 'cursor-pointer',
          ]"
        >
          Anterior
        </button>
      </li>

      <li v-for="(page, index) in visiblePages" :key="index" class="place-content-center">
        <span
          v-if="page === '...'"
          class="px-3 h-8 leading-tight text-gray-500 select-none"
        >
          ...
        </span>
        <button
          v-else
          @click="selectPage(page as number)"
          :disabled="page === props.currentPage"
          :class="[
            'px-3 h-8 leading-tight border ',
            page === props.currentPage
              ? 'flex items-center justify-center cursor-not-allowed px-4 h-10 border  hover:bg-blue-100 hover:text-blue-700 border-gray-700 bg-gray-700 text-white'
              : 'flex items-center justify-center cursor-pointer px-4 h-10 leading-tight  border  bg-gray-800 border-gray-700 text-gray-400 hover:bg-gray-700 hover:text-white',
          ]"
        >
          {{ page }}
        </button>
      </li>

      <li>
        <button
          :disabled="props.currentPage === props.totalPages"
          @click="selectPage(props.currentPage + 1)"
          class="flex items-center justify-center px-4 cursor-pointer h-10 leading-tight border rounded-e-lg bg-gray-800 border-gray-700 text-gray-400 hover:bg-gray-700 hover:text-white"
        >
          Próximo
        </button>
      </li>
    </ul>
  </nav>
</template>
