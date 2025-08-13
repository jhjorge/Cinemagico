<script setup lang="ts">
import type { Toast } from "@/types/toast";
import { ref, onMounted, onUnmounted } from "vue";

const props = withDefaults(defineProps<Toast>(), {
  duration: 8 * 1000,
});

const emit = defineEmits(["close"]);

const isVisible = ref(false);
let timer: ReturnType<typeof setTimeout> | null = null;

const show = () => {
  isVisible.value = true;
  if (timer) clearTimeout(timer);
  timer = setTimeout(() => {
    hide();
  }, props.duration);
};

const hide = () => {
  isVisible.value = false;
  emit("close");
};

onMounted(() => {
  show();
});

onUnmounted(() => {
  if (timer) clearTimeout(timer);
});

const typeClasses = {
  success: "text-green-500 bg-green-100 ",
  danger: "text-red-500 bg-red-100 ",
  warning: "text-orange-500 bg-orange-100 ",
  info: "bg-blue-100 text-blue-500",
  error: "bg-red-100  text-red-500",
};

const icons = {
  success: `<path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>`,
  danger: `<path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 11.793a1 1 0 1 1-1.414 1.414L10 11.414l-2.293 2.293a1 1 0 0 1-1.414-1.414L8.586 10 6.293 7.707a1 1 0 0 1 1.414-1.414L10 8.586l2.293-2.293a1 1 0 0 1 1.414 1.414L11.414 10l2.293 2.293Z"/>`,
  warning: `<path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM10 15a1 1 0 1 1 0-2 1 1 0 0 1 0 2Zm1-4a1 1 0 0 1-2 0V6a1 1 0 0 1 2 0v5Z"/>`,
  info: `<path d="M10 18a8 8 0 100-16 8 8 0 000 16zm-.25-11.75a.75.75 0 111.5 0v4.5a.75.75 0 01-1.5 0v-4.5zm0 7a.75.75 0 111.5 0v.5a.75.75 0 01-1.5 0v-.5z"/>`,
  error: `<path d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11.25a.75.75 0 00-1.5 0v4.5a.75.75 0 001.5 0v-4.5zm-1 7a.75.75 0 100 1.5.75.75 0 000-1.5z"/>`,
};
</script>

<template>
  <Transition name="fade">
    <div
      v-show="isVisible"
      class="flex items-center z-30 w-full max-w-xs p-2 sm:p-4 mb-4 text-white bg-[var(--color-third)]/95 backdrop-blur-lg rounded-lg shadow fixed bottom-2 right-2"
      role="alert"
    >
      <div
        :class="[
          'inline-flex items-center justify-center flex-shrink-0 w-8 h-8 rounded-lg',
          typeClasses[type],
        ]"
      >
        <svg
          class="w-5 h-5"
          aria-hidden="true"
          xmlns="http://www.w3.org/2000/svg"
          fill="currentColor"
          viewBox="0 0 20 20"
          v-html="icons[type] ?? ''"
        />

        <span class="sr-only">{{ type }} icon</span>
      </div>
      <div class="ms-3 text-sm font-normal text-shadow-md">{{ message }}</div>
      <button
        type="button"
        class="ms-auto -mx-1.5 -my-1.5 bg-[var(--color-primary)] text-white hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex items-center justify-center size-6"
        @click="hide"
        aria-label="Fechar Notificação"
      >
        <svg
          class="w-3 h-3"
          aria-hidden="true"
          xmlns="http://www.w3.org/2000/svg"
          fill="none"
          viewBox="0 0 14 14"
        >
          <path
            stroke="currentColor"
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"
          />
        </svg>
      </button>
    </div>
  </Transition>
</template>

<style scoped>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.5s ease;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
</style>
