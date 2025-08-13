import './assets/main.css'

import { createApp } from 'vue'
import { createPinia } from 'pinia'


import App from './App.vue'
import router from './router'
const APP_NAME = import.meta.env.VITE_APP_NAME;

const app = createApp(App)

app.use(createPinia())


router.beforeEach((to, from, next) => {
    const defaultTitle = APP_NAME ?? 'Cine Magico'
    document.title = to.meta.title ? `${to.meta.title} - ${defaultTitle}` : defaultTitle
    next()
})

app.use(router)

app.mount('#app')
