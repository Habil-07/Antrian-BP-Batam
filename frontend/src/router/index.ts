import { createRouter, createWebHistory } from 'vue-router'
import { authGuard } from './middleware'

const router = createRouter({
  history: createWebHistory(),
  routes: [
    // Public routes
    {
      path: '/',
      component: () => import('@/pages/HomePage.vue'),
    },
    {
      path: '/queue',
      component: () => import('@/pages/QueuePage.vue'), // Untuk display monitor
    },
    {
      path: '/service/:serviceName',
      name: 'ServiceDetail',
      component: () => import('@/pages/ServiceDetailPage.vue'),
    },
    {
      path: '/appointment',
      component: () => import('@/pages/AppointmentPage.vue'),
    },
    // Admin routes
    {
      path: '/admin/login',
      component: () => import('@/pages/admin/LoginPage.vue'),
    },
    {
      path: '/admin',
      meta: { requiresAuth: true },
      children: [
        {
          path: 'queue',
          component: () => import('@/pages/admin/QueuePage.vue'),
        },
        {
          path: 'all-queue',
          name: 'AdminAllQueue',
          component: () => import('@/pages/admin/AllQueuePage.vue'),
          meta: { requiresAuth: true },
        },
        {
          path: 'service/:serviceName',
          name: 'AdminServiceDetail',
          component: () => import('@/pages/admin/ServiceDetailPage.vue'),
        },
        {
          path: 'queue/:serviceName',
          name: 'AdminQueueDetail',
          component: () => import('@/pages/admin/AdminServiceDetailPage.vue'),
        },
      ],
    },
  ],
})

router.beforeEach(authGuard)

export default router
