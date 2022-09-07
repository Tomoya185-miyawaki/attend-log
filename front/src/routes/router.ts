import { createRouter,createWebHistory } from 'vue-router';
import LoginPage from '@/pages/admin/LoginPage.vue'
import PasswordReset from '@/pages/admin/PasswordReset.vue'
import NotFoundPage from '@/pages/NotFoundPage.vue'

const routes = [
  { path: '/admin/login', name: 'login', component: LoginPage },
  { path: '/admin/password-reset', name: 'passwordReset', component: PasswordReset },
  { path: '/:catchAll(.*)', component: NotFoundPage },
]

const router = createRouter({
    history: createWebHistory(),
    routes,
})

export default router;