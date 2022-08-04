import { createRouter,createWebHistory } from 'vue-router';
import Login from '@/pages/admin/Login.vue'
import NotFound from '@/pages/NotFound.vue'

const routes = [
  { path: '/admin/login', name: 'login', component: Login },
  { path: '/:catchAll(.*)', component: NotFound },
]

const router = createRouter({
    history: createWebHistory(),
    routes,
})

export default router;