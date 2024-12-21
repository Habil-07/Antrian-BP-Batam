import type { NavigationGuardNext, RouteLocationNormalized } from 'vue-router'

export function authGuard(
  to: RouteLocationNormalized,
  from: RouteLocationNormalized,
  next: NavigationGuardNext,
) {
  const isAdmin = localStorage.getItem('isAdmin')

  if (to.matched.some((record) => record.meta.requiresAuth)) {
    if (!isAdmin) {
      next('/admin/login')
    } else {
      next()
    }
  } else {
    next()
  }
}
