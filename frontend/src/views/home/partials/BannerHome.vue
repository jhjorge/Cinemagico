<script setup lang="ts"></script>
<template>
  <div
    class="w-full h-[60dvh] bg-[url('@/assets/imgs/banner.jpg')] bg-cover bg-center place-content-end bg-no-repeat shadow-2xl sm:bg-fixed p-4"
  >
    <div class="container mx-auto">
      <Transition
        name="fade-slide"
        appear
        enter-active-class="transition duration-700 ease-out"
        enter-from-class="opacity-0 translate-y-4"
        enter-to-class="opacity-100 translate-y-0"
      >
        <div
          class="bg-gray-900/70 backdrop-blur-md rounded-2xl max-w-md w-full p-6 text-white shadow-lg text-shadow-sm"
        >
          <h1 class="text-[clamp(2rem,10vw,3rem)] font-bold mb-4 leading-tight">
            Descubra e Salve Seus Filmes Favoritos
          </h1>
          <p class="text-base sm:text-xl leading-relaxed">
            Encontre os filmes mais populares, os lançamentos mais aguardados e os grandes
            clássicos do cinema. Busque por título e crie sua própria lista de favoritos,
            tudo em um só lugar.
          </p>
        </div>
      </Transition>
    </div>
  </div>
</template>
