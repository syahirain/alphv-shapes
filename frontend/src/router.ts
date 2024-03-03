import { createRouter, createWebHashHistory, RouteRecordRaw } from 'vue-router'
import { useAuthStore } from '@/store/auth'

const routes: Array<RouteRecordRaw> = [
  {
    path: '/',
    name: 'Home',
    component: () => import('@/components/Home.vue'),
  },
  {
    path: '/overview',
    name: 'Overview',
    component: () => import('@/components/Overview.vue'),
    meta: { requiresAuth: true },
  },
  {
    path: '/listing',
    name: 'Listing',
    component: () => import('@/components/Listing.vue'),
    meta: { requiresAuth: true },
  },
  {
    path: '/login',
    name: 'Login',
    component: () => import('@/components/Login.vue'),
  },
];

const router = createRouter({
  history: createWebHashHistory(),
  routes,
});

router.beforeEach((to, _, next) => {
  const authStore = useAuthStore()

  // Check if the route requires authentication and the user is not authenticated
  if (to.matched.some(record => record.meta.requiresAuth) && !authStore.isAuthenticated()) {
    // Redirect to the login page or any other route you prefer
    next({ name: 'Login' });
  } else {
    // Continue to the next route
    next();
  }
});

export default router;
