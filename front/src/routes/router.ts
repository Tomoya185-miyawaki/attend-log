import { createRouter, createWebHistory } from 'vue-router';
import { isAdminLoggedIn } from '@/util/auth';
import LoginPage from '@/pages/admin/LoginPage.vue'
import PasswordReset from '@/pages/admin/PasswordReset.vue'
import NotFoundPage from '@/pages/NotFoundPage.vue'

const routes = [
  {
    path: '/admin/login',
    name: 'login',
    component: LoginPage,
    meta: { adminGuestOnly: true }
  },
  {
    path: '/admin/password-reset',
    name: 'passwordReset',
    component: PasswordReset,
    meta: { adminGuestOnly: true }
  },
  {
    path: '/:catchAll(.*)',
    component: NotFoundPage
  },
]

const router = createRouter({
    history: createWebHistory(),
    routes,
})

router.beforeEach((to, _, next) => {
  if (to.matched.some(record => record.meta.adminAuthOnly)) {
    if (!isAdminLoggedIn()) {
      return next('/admin/login')
    }
    return next()
  }
  if (to.matched.some(record => record.meta.adminGuestOnly)) {
    if (isAdminLoggedIn()) {
      return next('/admin')
    }
    return next()
  }
  return next()
})

export default router;