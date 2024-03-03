const routes = [
  {
    path: '/',
    name: 'home',
    component: () => import('../pages/HomePage.vue'),
    meta: {
      title: 'Accueil', private: false,
    },
  },
  {
    path: '/mon-compte',
    name: 'account',
    component: () => import('../pages/AccountPage.vue'),
    meta: {
      title: 'Mon compte', private: true,
    },
  },
  {
    path: '/mes-commandes',
    name: 'orders',
    component: () => import('../pages/order/OrdersPage.vue'),
    meta: {
      title: 'Mes commandes', private: true,
    },
  },
  {
    path: '/mes-commandes/:id',
    name: 'order',
    component: () => import('../pages/order/OrderPage.vue'),
    meta: {
      title: 'Ma commande', private: true,
    },
  },
  {
    path: '/categories',
    name: 'categories',
    component: () => import('../pages/category/CategoriesPage.vue'),
    meta: {
      title: 'Catégories', private: false,
    },
  },
  {
    path: '/produits',
    name: 'products',
    children: [
      {
        path: '',
        name: 'products',
        component: () => import('../pages/product/ProductsPage.vue'),
        meta: {
          title: 'Produits', private: false,
        },
      },
      {
        path: ':slug',
        name: 'product',
        component: () => import('../pages/product/ProductPage.vue'),
        meta: {
          title: 'Produit', private: false,
        },
      },
    ],
    meta: {
      title: 'Produits', private: false,
    },
  },
  {
    path: '/recherche',
    name: 'search',
    component: () => import('../pages/SearchPage.vue'),
    meta: {
      title: 'Recherche', private: false,
    },
  },
  {
    path: '/paiement',
    name: 'checkout',
    component: () => import('../pages/CheckoutPage.vue'),
    meta: {
      title: 'Paiement', private: true,
    },
  },
  {
    path: '/panier',
    name: 'cart',
    component: () => import('../pages/CartPage.vue'),
    meta: {
      title: 'Panier', private: false,
    },
  },
  {
    path: '/contact',
    name: 'contact',
    component: () => import('../pages/ContactPage.vue'),
    meta: {
      title: 'Contact', private: false,
    },
  },
  {
    path: '/plan-du-site',
    name: 'sitemap',
    component: () => import('../pages/SitemapPage.vue'),
    meta: {
      title: 'Plan du site', private: false,
    },
  },
  {
    path: '/mentions-legales',
    name: 'legal-notices',
    component: () => import('../pages/LegalNoticesPage.vue'),
    meta: {
      title: 'Mentions légales', private: false,
    },
  },
  {
    path: '/conditions-generales-d-utilisation',
    name: 'gcu',
    component: () => import('../pages/GcuPage.vue'),
    meta: {
      title: 'Conditions générales d\'utilisation', private: false,
    },
  },
  {
    path: '/404',
    name: '404',
    component: () => import('../pages/error/ErrorNotFound.vue'),
  },
  {
    path: '/:catchAll(.*)*',
    component: () => import('../pages/error/ErrorNotFound.vue'),
  },
]

export default routes
