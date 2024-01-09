const routes = [
  {
    path: '/',
    name: 'Accueil',
    component: () => import('../pages/HomePage.vue'),
    meta: { title: 'Accueil' },
  },
  {
    path: '/categories',
    name: 'Catégories',
    component: () => import('../pages/CategoriesPage.vue'),
    meta: { title: 'Catégories' },
  },
  {
    path: '/contact',
    name: 'Contact',
    component: () => import('../pages/ContactPage.vue'),
    meta: { title: 'Contact' },
  },
  {
    path: '/about',
    name: 'À propos',
    component: () => import('../pages/AboutPage.vue'),
    meta: { title: 'À propos' },
  },
  {
    path: '/plan-du-site',
    name: 'Plan du site',
    component: () => import('../pages/PlanDuSitePage.vue'),
    meta: { title: 'Plan du site' },
  },
  {
    path: '/mentions-legales',
    name: 'Mentions légales',
    component: () => import('../pages/MentionsLegalesPage.vue'),
    meta: { title: 'Mentions légales' },
  },
  {
    path: '/:catchAll(.*)*',
    component: () => import('../pages/error/ErrorNotFound.vue'),
  },
]

export default routes
