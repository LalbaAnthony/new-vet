import { createRouter, createWebHistory } from 'vue-router'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  scrollBehavior: () => ({ left: 0, top: 0 }),
  routes: [
    {
      path: '/',
      name: 'Accueil',
      component: () => import('../pages/HomePage.vue'),
    },
    {
      path: '/categories',
      name: 'Catégories',
      component: () => import('../pages/CategoriesPage.vue'),
    },
    {
      path: '/contact',
      name: 'Contact',
      component: () => import('../pages/ContactPage.vue'),
    },
    {
      path: '/about',
      name: 'À propos',
      component: () => import('../pages/AboutPage.vue'),
    },
    {
      path: '/plan-du-site',
      name: 'Plan du site',
      component: () => import('../pages/PlanDuSitePage.vue'),
    },
    {
      path: '/mentions-legales',
      name: 'Mentions légales',
      component: () => import('../pages/MentionsLegalesPage.vue'),
    },
    {
      path: '/:catchAll(.*)*',
      component: () => import('../pages/error/ErrorNotFound.vue'),
    },
  ],
})

export default router