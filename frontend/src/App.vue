<script setup lang="ts">
import { RouterView } from "vue-router";
import NavBar from "@/components/layout/NavBar.vue";
import FooterBar from "./components/layout/FooterBar.vue";
import { useToastStore } from "@/stores/toast";
import Toast from "@/components/ui/Toast.vue";
const toastStore = useToastStore();
</script>

<template>
  <div class="bg-[var(--color-third)]">
    <NavBar />
    <main class="min-h-screen">
      <Toast
        v-for="(toast, index) in toastStore.toasts"
        :key="index"
        v-bind="toast"
        @close="toastStore.removeToast(index)"
      />

      <RouterView />
    </main>
    <FooterBar />
  </div>
</template>

<style lang="sass" scoped></style>
