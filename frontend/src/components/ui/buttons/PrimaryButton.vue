<template>
  <button
    type="button"
    class="inline-flex items-center justify-center gap-2 bg-[var(--color-primary)] font-semibold px-5 py-2.5 rounded-xl shadow-md hover:bg-opacity-90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[var(--color-primary)] transition-all duration-200 hover:cursor-pointer hover:bg-[var(--color-primary)]/90 hover:scale-105"
  >
    <slot />
  </button>
</template>
