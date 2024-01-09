import { createRouter, createWebHistory } from 'vue-router'
import routes from './routes'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  scrollBehavior: () => ({ left: 0, top: 0 }),
  routes,
})

router.beforeEach((to, from, next) => {
  document.title = `${to.meta.title} - NEW VET` || 'NEW VET';
  next();
});

export default router