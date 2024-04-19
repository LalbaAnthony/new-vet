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
    children: [
      {
        path: '',
        name: 'account-default',
        component: () => import('../pages/account/DefaultPage.vue'),
      },
      {
        path: 'infos',
        name: 'account-infos',
        component: () => import('../pages/account/InfosPage.vue'),
        meta: {
          title: 'Mes informations', private: true, breadcrumb: [
            {
              title: 'Mon compte',
              path: '/mon-compte',
              active: false
            },
            {
              title: 'Mes informations',
              path: null,
              active: true
            }
          ],
        },
      },
      {
        path: 'securite',
        name: 'account-security',
        component: () => import('../pages/account/SecurityPage.vue'),
        meta: {
          title: 'Sécurité', private: true, breadcrumb: [
            {
              title: 'Mon compte',
              path: '/mon-compte',
              active: false
            },
            {
              title: 'Sécurité',
              path: null,
              active: true
            }
          ],
        },
      },
      {
        path: 'mes-adresses',
        name: 'account-addresses',
        component: () => import('../pages/account/AddressesPage.vue'),
        meta: {
          title: 'Mes adresses', private: true, breadcrumb: [
            {
              title: 'Mon compte',
              path: '/mon-compte',
              active: false
            },
            {
              title: 'Mes adresses',
              path: null,
              active: true
            }
          ],
        },
      },
      {
        path: 'mes-commandes',
        name: 'account-orders',
        children: [
          {
            path: '',
            name: 'account-orders-list',
            component: () => import('../pages/account/order/OrdersPage.vue'),
          },
          {
            path: ':order_id',
            name: 'account-orders-details',
            component: () => import('../pages/account/order/OrderPage.vue'),
            meta: {
              title: 'Détail de ma commande', private: true, breadcrumb: [
                {
                  title: 'Mon compte',
                  path: '/mon-compte',
                  active: false
                },
                {
                  title: 'Mes commandes',
                  path: '/mon-compte/mes-commandes',
                  active: false
                },
                {
                  title: 'Détail de ma commande',
                  path: null,
                  active: true
                }
              ],
            },
          },
        ],
        meta: {
          title: 'Mes commandes', private: true, breadcrumb: [
            {
              title: 'Mon compte',
              path: '/mon-compte',
              active: false
            },
            {
              title: 'Mes commandes',
              path: null,
              active: true
            }
          ],
        },
      },
      {
        path: 'mes-moyens-de-paiement',
        name: 'account-payments',
        component: () => import('../pages/account/PaymentsPage.vue'),
        meta: {
          title: 'Mes moyens de paiement', private: true, breadcrumb: [
            {
              title: 'Mon compte',
              path: '/mon-compte',
              active: false
            },
            {
              title: 'Mes moyens de paiement',
              path: null,
              active: true
            }
          ],
        },
      },
    ],
    meta: {
      title: 'Mon compte', private: true, breadcrumb: [
        {
          title: 'Mon compte',
          path: null,
          active: true
        }
      ],
    },
  },
  {
    path: '/categories',
    name: 'categories',
    component: () => import('../pages/category/CategoriesPage.vue'),
    meta: {
      title: 'Catégories', private: false, breadcrumb: [
        {
          title: 'Catégories',
          path: null,
          active: true
        }
      ],
    },
  },
  {
    path: '/produits',
    name: 'products',
    children: [
      {
        path: '',
        name: 'products-list',
        component: () => import('../pages/product/ProductsPage.vue'),
      },
      {
        path: ':slug',
        name: 'products-details',
        component: () => import('../pages/product/ProductPage.vue'),
        meta: {
          title: 'Produit', private: false, breadcrumb: [
            {
              title: 'Produits',
              path: '/produits',
              active: false
            },
            {
              title: 'Produit',
              path: null,
              active: true
            }
          ],
        },
      },
    ],
    meta: {
      title: 'Produits', private: false, breadcrumb: [
        {
          title: 'Produits',
          path: null,
          active: true
        }
      ],
    },
  },
  {
    path: '/recherche',
    name: 'search',
    component: () => import('../pages/SearchPage.vue'),
    meta: {
      title: 'Recherche', private: false, breadcrumb: [
        {
          title: 'Recherche',
          path: null,
          active: true
        }
      ],
    },
  },
  {
    path: '/paiement',
    name: 'checkout',
    component: () => import('../pages/CheckoutPage.vue'),
    meta: {
      title: 'Paiement', private: true, breadcrumb: [
        {
          title: 'Paiement',
          path: null,
          active: true
        }
      ],
    },
  },
  {
    path: '/panier',
    name: 'cart',
    component: () => import('../pages/cart/CartPage.vue'),
    meta: {
      title: 'Panier', private: false, breadcrumb: [
        {
          title: 'Panier',
          path: null,
          active: true
        }
      ],
    },
  },
  {
    path: '/contact',
    name: 'contact',
    component: () => import('../pages/ContactPage.vue'),
    meta: {
      title: 'Contact', private: false, breadcrumb: [
        {
          title: 'Contact',
          path: null,
          active: true
        }
      ],
    },
  },
  {
    path: '/plan-du-site',
    name: 'sitemap',
    component: () => import('../pages/SitemapPage.vue'),
    meta: {
      title: 'Plan du site', private: false, breadcrumb: [
        {
          title: 'Plan du site',
          path: null,
          active: true
        }
      ],
    },
  },
  {
    path: '/mentions-legales',
    name: 'legal-notices',
    component: () => import('../pages/LegalNoticesPage.vue'),
    meta: {
      title: 'Mentions légales', private: false, breadcrumb: [
        {
          title: 'Mentions légales',
          path: null,
          active: true
        }
      ],
    },
  },
  {
    path: '/conditions-generales-d-utilisation',
    name: 'gcu',
    component: () => import('../pages/GcuPage.vue'),
    meta: {
      title: 'Conditions générales d\'utilisation', private: false, breadcrumb: [
        {
          title: 'Conditions générales d\'utilisation',
          path: null,
          active: true
        }
      ],
    },
  },
  {
    path: '/conditions-generales-de-vente',
    name: 'gcs',
    component: () => import('../pages/GcsPage.vue'),
    meta: {
      title: 'Conditions générales de vente', private: false, breadcrumb: [
        {
          title: 'Conditions générales de vente',
          path: null,
          active: true
        }
      ],
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