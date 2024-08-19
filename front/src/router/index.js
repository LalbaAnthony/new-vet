import { createRouter, createWebHistory } from 'vue-router'
import routes from './routes'
import { useAuthStore } from '@/stores/auth'
import { SITE_NAME } from '@/config';

const router = createRouter({
  history: createWebHistory(),
  scrollBehavior: () => ({ left: 0, top: 0, behavior: 'smooth' }),
  routes,
})

router.beforeEach((to, from, next) => {

  if (from.name === 'place-order-page') {
    const quit = confirm('Êtes-vous sûr de vouloir quittez la page ?')
    if (!quit) return next(false)
  }

  const authStore = useAuthStore()
  if (to.meta.private === true) {
    authStore.validateToken()
  }

  document.title = `${to.meta.title} - ${SITE_NAME}` || SITE_NAME;

  next();
});

router.afterEach(() => {
  window.scrollTo({ top: 0, behavior: 'smooth' });
});

export default router