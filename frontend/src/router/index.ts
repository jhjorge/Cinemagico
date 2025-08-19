import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '@/views/home/Index.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: HomeView,
      meta: {
        title: 'Página Inicial'
      }
    },
    {
      path: '/favoritos',
      name: 'favorites',
      component: () => import('../views/favorites/Index.vue'),
      meta: {
        title: 'Favoritos'
      }
    },
    {
      path: '/movie/:id', // 
      name: 'movie-detail',
      component: () => import('@/views/movie/Index.vue'),
      meta: {
        title: 'Detalhes do Filme'
      },
      props: true,
    }
  ],
})

export default router
