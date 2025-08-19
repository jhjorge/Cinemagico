<template>
  <div>
    <div class="w-full h-[60vh] md:h-[70vh] bg-gray-800 animate-pulse relative">
      <div class="absolute inset-0 bg-[var(--color-third)]/60"></div>
      <div class="flex flex-col justify-end p-6 container mx-auto h-full">
        <div class="h-8 md:h-12 bg-gray-600 rounded w-3/5 mb-2"></div>
        <div class="h-4 bg-gray-600 rounded w-2/5 mb-2"></div>
        <div class="flex flex-wrap gap-2 mt-2">
          <div class="h-6 bg-gray-600 rounded w-16"></div>
          <div class="h-6 bg-gray-600 rounded w-12"></div>
          <div class="h-6 bg-gray-600 rounded w-20"></div>
        </div>
      </div>
    </div>

    <div class="container mx-auto p-6 md:p-12 space-y-6">
      <div class="h-4 bg-gray-600 rounded w-full"></div>
      <div class="h-4 bg-gray-600 rounded w-5/6"></div>
      <div class="h-4 bg-gray-600 rounded w-3/4"></div>

      <ul class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-gray-300 text-sm">
        <li><div class="h-4 bg-gray-600 rounded w-2/3"></div></li>
        <li><div class="h-4 bg-gray-600 rounded w-1/2"></div></li>
        <li><div class="h-4 bg-gray-600 rounded w-1/3"></div></li>
        <li><div class="h-4 bg-gray-600 rounded w-2/5"></div></li>
        <li><div class="h-4 bg-gray-600 rounded w-1/2"></div></li>
        <li><div class="h-4 bg-gray-600 rounded w-1/3"></div></li>
        <li><div class="h-4 bg-gray-600 rounded w-3/4"></div></li>
        <li><div class="h-4 bg-gray-600 rounded w-2/3"></div></li>
      </ul>

      <div class="h-10 w-40 bg-gray-600 rounded mt-4"></div>
    </div>
  </div>
</template>

<script setup lang="ts"></script>

<style scoped></style>
