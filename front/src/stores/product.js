import { defineStore } from 'pinia'
import { get } from '@/helpers/api';
import { useAuthStore } from '@/stores/auth'

const authStore = useAuthStore()

export const useProductStore = defineStore('product', {
  state: () => ({
    product: {
      loading: false,
      data: {},
    },
    products: {
      loading: false,
      data: [],
    },
    moreProducts: {
      loading: false,
      data: [],
    },
    highlandersProducts: {
      loading: false,
      data: [],
    },
    cartProducts: {
      loading: false,
      data: [],
    },
    pagination: { page: 1, perPage: 8 },
  }),

  actions: {
    async fetchProduct(slug) {
      // Loading
      this.product.loading = true

      // Data
      this.product.data = {}

      const resp = await get('products', { slug: slug, per_page: 1 });
      this.product.data = resp[0];

      // Loading
      this.product.loading = false
    },

    async fetchProducts(givenParams = {}) {

      // Loading
      this.products.loading = true

      // Data
      this.products.data = []

      // Request
      const params = {
        page: this.pagination.currentPage,
        per_page: this.pagination.perPage,
        order_by: 'sort_order',
        order_direction: 'asc',
      }
      Object.assign(params, givenParams)

      this.products.data = await get('products', params);

      // Loading
      this.products.loading = false
    },

    async fetchHighlandersProducts() {
      // Loading
      this.highlandersProducts.loading = true

      // Data
      this.highlandersProducts.data = []

      this.highlandersProducts.data = await get('products', { is_highlander: true, per_page: 3 });

      // Loading
      this.highlandersProducts.loading = false
    },

    async fetchMoreProducts(categorySlug = '') {
      // Loading
      this.moreProducts.loading = true

      // Data
      this.moreProducts.data = []

      this.moreProducts.data = await get('products', { categories: [categorySlug], per_page: 3, exclude: [this.product.data.slug] });

      // Loading
      this.moreProducts.loading = false
    },

    async fetchCartProducts() {
      // Loading
      this.cartProducts.loading = true

      // Data
      this.cartProducts.data = []

      const productSlugs = Object.keys(authStore.cart);
      this.cartProducts.data = await get('products', { include: [productSlugs.join(',')] });

      // Loading
      this.cartProducts.loading = false
    }
  },
})
