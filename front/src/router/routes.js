const routes = [
  {
    path: '/',
    name: 'home',
    component: () => import('../pages/HomePage.vue'),
    meta: { title: 'Accueil' },
  },
  {
    path: '/se-connecter',
    name: 'sign',
    component: () => import('../pages/SignPage.vue'),
    meta: { title: 'Se connecter' },
  },
  {
    path: '/mon-compte',
    name: 'account',
    component: () => import('../pages/AccountPage.vue'),
    meta: { title: 'Mon compte' },
  },
  {
    path: '/mes-commandes',
    name: 'orders',
    component: () => import('../pages/OrdersPage.vue'),
    meta: { title: 'Mes commandes' },
  },
  {
    path: '/mes-commandes/:id',
    name: 'order',
    component: () => import('../pages/OrderPage.vue'),
    meta: { title: 'Ma commande' },
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
    path: '/recherche',
    name: 'search',
    component: () => import('../pages/SearchPage.vue'),
    meta: { title: 'Recherche' },
  },
  {
    path: '/paiement',
    name: 'checkout',
    component: () => import('../pages/CheckoutPage.vue'),
    meta: { title: 'Paiement' },
  },
  {
    path: '/panier',
    name: 'cart',
    component: () => import('../pages/CartPage.vue'),
    meta: { title: 'Panier' },
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
    path: '/:catchAll(.*)*',
    component: () => import('../pages/error/ErrorNotFound.vue'),
  },
]

export default routes
