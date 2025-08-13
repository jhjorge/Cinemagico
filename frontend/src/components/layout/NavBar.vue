<script setup lang="ts">
import { RouterLink, useRoute } from "vue-router";
import Logo from "@/components/ui/Logo.vue";
import HamburgerButton from "../ui/buttons/HamburgerButton.vue";
import { ref } from "vue";
import FavoriteButton from "../ui/buttons/FavoriteButton.vue";
const route = useRoute();

const menu: { title: string; link: string; icon?: string }[] = [
  {
    title: "Página Incial",
    link: "/",
    icon: "",
  },

  {
    title: "Favoritos",
    link: "/favoritos",
    icon: "",
  },
];
const toggle_menu = ref(false);
const toggleMenu = () => {
  toggle_menu.value = !toggle_menu.value;
};
</script>
<template>
  <header
    class="bg-[var(--color-primary)] shadow-md sticky w-full back top-0 start-0 z-50"
  >
    <nav class="container mx-auto">
      <div
        class="md:grid md:grid-cols-[0.5fr_auto_0.5fr] flex justify-between items-center p-4"
      >
        <div class="w-12 hover:scale-110 transition-all ease-in-out duration-300">
          <RouterLink to="/">
            <Logo />
          </RouterLink>
        </div>
        <div class="hidden md:flex justify-center">
          <ul class="flex gap-6 font-medium text-white">
            <li v-for="(item, index) in menu" :key="index">
              <RouterLink
                :to="item.link"
                :class="[
                  'transition-colors duration-200 border-b ',
                  route.path === item.link
                    ? 'text-[var(--color-secondary)] border-[var(--color-secondary)] font-semibold'
                    : 'text-white hover:border-[var(--color-secondary)] border-transparent',
                ]"
              >
                {{ item.title }}
              </RouterLink>
            </li>
          </ul>
        </div>

        <div class="flex justify-end items-center space-x-3">
          <RouterLink to="/favoritos">
            <FavoriteButton class="cursor-pointer">Favoritos</FavoriteButton>
          </RouterLink>

          <HamburgerButton :toggle_menu @toggle="toggleMenu" />
        </div>
      </div>
      <div
        :class="[
          'items-center justify-between w-full md:hidden fixed top z-20 bg-[var(--color-third)] text-white border-b border-white py-2  ',
          toggle_menu ? 'block' : 'hidden',
        ]"
        id="navbar-sticky"
      >
        <ul
          class="flex flex-col gap-4 font-medium rounded-b-md p-2 bg-[var(--color-fifth)]"
        >
          <li v-for="(item, index) in menu" :key="index" @click="toggleMenu">
            <RouterLink
              :key="index"
              :to="item.link"
              :class="[
                'transition-colors duration-200 border-b py-2 w-full',
                route.path === item.link
                  ? 'text-[var(--color-secondary)] border-[var(--color-secondary)] font-semibold'
                  : 'text-white hover:text-[var(--color-primary)] border-transparent',
              ]"
            >
              {{ item.title }}
            </RouterLink>
          </li>
        </ul>
      </div>
    </nav>
  </header>
</template>

<style lang=""></style>
