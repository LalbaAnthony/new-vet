const routes = [
  {
    path: '/',
    name: 'home',
    component: () => import('../pages/HomePage.vue'),
    meta: { title: 'Accueil' },
  },
  {
    path: '/categories',
    name: 'categories',
    component: () => import('../pages/CategoriesPage.vue'),
    meta: { title: 'Catégories' },
  },
  {
    path: '/categories/:slug',
    name: 'category',
    component: () => import('../pages/CategoryPage.vue'),
    meta: { title: 'Catégorie' },
  },
  {
    path: '/produits',
    name: 'products',
    component: () => import('../pages/ProductsPage.vue'),
    meta: { title: 'Produits' },
  },
  {
    path: '/produits/:slug',
    name: 'product',
    component: () => import('../pages/ProductPage.vue'),
    meta: { title: 'Produit' },
  },
  {
    path: '/contact',
    name: 'contact',
    component: () => import('../pages/ContactPage.vue'),
    meta: { title: 'Contact' },
  },
  {
    path: '/plan-du-site',
    name: 'planDuSite',
    component: () => import('../pages/PlanDuSitePage.vue'),
    meta: { title: 'Plan du site' },
  },
  {
    path: '/mentions-legales',
    name: 'mentionsLegales',
    component: () => import('../pages/MentionsLegalesPage.vue'),
    meta: { title: 'Mentions légales' },
  },
  {
    path: '/panier',
    name: 'cart',
    component: () => import('../pages/CartPage.vue'),
    meta: { title: 'Panier' },
  },
  {
    path: '/:catchAll(.*)*',
    component: () => import('../pages/error/ErrorNotFound.vue'),
  },
]

export default routes
