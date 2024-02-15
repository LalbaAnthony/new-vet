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


  const privatePages = ['account', 'orders', 'order', 'checkout']
  const authStore = useAuthStore()
  if (!authStore.authenticated && privatePages.includes(to.name)) {
    next({ path: '/' });
  }

  next();
});

router.afterEach(() => {
  window.scrollTo(0, 0);
});

export default router