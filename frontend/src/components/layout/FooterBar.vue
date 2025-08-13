<script setup lang="ts">
import { RouterLink } from "vue-router";
import Logo from "../ui/Logo.vue";
const menu: { title: string; link: string }[] = [
  {
    title: "Home",
    link: "/",
  },
  {
    title: "Favoritos",
    link: "/favoritos",
  },
];
const year: number = new Date().getFullYear();
</script>
<template>
  <footer class="bg-[var(--color-primary)] text-white shadow-sm">
    <div class="w-full container mx-auto p-4">
      <div class="flex md:flex-row flex-col gap-4 sm:items-center sm:justify-between">
        <div class="flex justify-center">
          <RouterLink to="/" class="w-36 md:w-20 shrink-0">
            <Logo />
          </RouterLink>
        </div>
        <ul
          class="flex flex-wrap items-center gap-4 justify-center text-sm font-medium sm:mb-0"
        >
          <li v-for="{ title, link } in menu" :key="title">
            <RouterLink :to="link" class="hover:underline">{{ title }}</RouterLink>
          </li>
        </ul>
      </div>
      <hr class="my-6 border-gray-200 sm:mx-auto lg:my-8" />
      <span class="block text-sm sm:text-center"
        >© {{ year }}
        <a
          href="https://www.linkedin.com/in/jhjorgex/"
          target="_blank"
          class="hover:underline"
          >Designed by João Henrique Jorge</a
        ></span
      >
    </div>
  </footer>
</template>
<style lang="scss" scoped></style>
