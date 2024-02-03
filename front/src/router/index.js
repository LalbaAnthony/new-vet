import { createRouter, createWebHistory } from 'vue-router'
import routes from './routes'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  scrollBehavior: () => ({ left: 0, top: 0 , behavior: 'smooth' }),
  routes,
})

router.beforeEach((to, from, next) => {
  document.title = `${to.meta.title} - NEW VET` || 'NEW VET';
  next();
});

router.afterEach(() => {
  window.scrollTo(0, 0);
});

export default router