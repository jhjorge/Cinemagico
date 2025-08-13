<script setup lang="ts">
const props = defineProps<{
  loading: boolean;
}>();
const modelValue = defineModel<string>();
const emit = defineEmits<{
  (e: "search", value: string): void;
}>();
const onSearch = () => {
  if (modelValue.value?.trim()) {
    emit("search", modelValue.value);
  }
};
</script>
<template>
  <form @submit.prevent="onSearch" class="flex items-center max-w-lg w-full gap-4">
    <div class="relative w-full">
      <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
        <span class="material-symbols-outlined text-gray-400"> mystery </span>
      </div>
      <input
        v-model="modelValue"
        :disabled="loading"
        type="search"
        placeholder="Buscar por título..."
        :class="[loading ? 'cursor-progress' : 'cursor-pointer']"
        class="bg-gray-800 text-white placeholder-gray-400 border border-gray-600 text-sm rounded-lg block w-full ps-10 p-2.5 focus:ring-[var(--color-secondary)]focus:border-[var(--color-secondary)]"
      />
    </div>
    <button
      type="submit"
      :disabled="loading"
      class="inline-flex items-center justify-center gap-2 bg-[var(--color-primary)] text-white font-semibold px-5 py-2.5 rounded-xl shadow-md hover:bg-opacity-90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[var(--color-primary)] transition-all duration-200"
      :class="[loading ? 'cursor-progress opacity-65' : 'cursor-pointer']"
    >
      Buscar
    </button>
  </form>
</template>
