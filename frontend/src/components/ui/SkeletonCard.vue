<script setup lang="ts"></script>
<template>
  <article
    class="max-w-sm rounded-2xl overflow-hidden shadow-md relative h-[66dvh] md:h-[50dvh] bg-white/30 animate-pulse hover:cursor-progress"
  >
    <div class="w-full h-full bg-gray-300/30"></div>

    <div
      class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-transparent"
    ></div>

    <footer class="absolute bottom-0 z-20 p-4 w-full space-y-2">
      <div class="h-6 bg-gray-400 rounded w-3/4"></div>

      <div class="h-4 bg-gray-400 rounded w-1/3"></div>

      <div class="h-4 bg-yellow-400 rounded w-1/5"></div>

      <div class="h-16 bg-gray-400 rounded mt-2"></div>

      <div class="w-24 h-8 bg-gray-400 rounded mt-4"></div>
    </footer>
  </article>
</template>

<style scoped>
@keyframes pulse {
  0%,
  100% {
    opacity: 1;
  }
  50% {
    opacity: 0.4;
  }
}
.animate-pulse {
  animation: pulse 1.5s ease-in-out infinite;
}
</style>
