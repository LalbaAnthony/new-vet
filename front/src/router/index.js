import { createRouter, createWebHistory } from 'vue-router'
import routes from './routes'
import { useAuthStore } from '@/stores/auth'

const router = createRouter({
  history: createWebHistory(),
  scrollBehavior: () => ({ left: 0, top: 0, behavior: 'smooth' }),
  routes,
})

router.beforeEach((to, from, next) => {
  document.title = `${to.meta.title} - NEW VET` || 'NEW VET';

  const authStore = useAuthStore()
  if (to.meta.private === true && !authStore.authenticated) {
    next({ path: '/' });
  }

  next();
});

router.afterEach(() => {
  window.scrollTo({ top: 0, behavior: 'smooth' });
});

export default router