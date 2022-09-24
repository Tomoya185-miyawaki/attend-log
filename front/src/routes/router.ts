import { createRouter, createWebHistory } from 'vue-router';
import { isAdminLoggedIn } from '@/util/auth';
import LoginPage from '@/pages/admin/LoginPage.vue'
import PasswordReset from '@/pages/admin/PasswordReset.vue'
import EmployeeList from '@/pages/admin/employee/List.vue'
import EmployeeCreate from '@/pages/admin/employee/Create.vue'
import EmployeeEdit from '@/pages/admin/employee/Edit.vue'
import StampList from '@/pages/admin/stamp/List.vue'
import AdminErrorPage from '@/pages/admin/ErrorPage.vue'
import AdminNotFoundPage from '@/pages/admin/NotFoundPage.vue'

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
    path: '/admin/employee',
    name: 'employeeList',
    component: EmployeeList,
    meta: { adminAuthOnly: true }
  },
  {
    path: '/admin/employee/create',
    name: 'employeeCreate',
    component: EmployeeCreate,
    meta: { adminAuthOnly: true }
  },
  {
    path: '/admin/employee/:employeeId/edit',
    name: 'employeeEdit',
    component: EmployeeEdit,
    meta: { adminAuthOnly: true }
  },
  {
    path: '/admin/stamp',
    name: 'stampList',
    component: StampList,
    meta: { adminAuthOnly: true }
  },
  {
    path: '/admin/error',
    name: 'adminError',
    component: AdminErrorPage
  },
  {
    path: '/admin/:catchAll(.*)',
    component: AdminNotFoundPage
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