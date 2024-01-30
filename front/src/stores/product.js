import { defineStore } from 'pinia'
import { get } from '@/helpers/api';

export const useProductStore = defineStore('product', {
  state: () => ({
    product: {},
    products: [],
    highlandersProducts: [],
    pagination: { page: 1, perPage: 8 },
    loading: false,
  }),

  actions: {
    async fetchProduct(slug) {
      // Loading
      this.loading = true

      // Data
      this.product = {}

      this.product = await get(`products/${slug}`);

      // Loading
      this.loading = false
    },

    async fetchProducts(givenParams = {}) {

      // Loading
      this.loading = true

      // Data
      this.products = []

      // Request
      const params = {
        page: this.pagination.currentPage,
        per_page: this.pagination.perPage,
      }
      Object.assign(params, givenParams)

      this.products = await get('products', params);

      // Loading
      this.loading = false
    },

    async fetchHighlandersProducts() {
      // Loading
      this.loading = true

      // Data
      this.highlandersProducts = []

      this.highlandersProducts = await get('products', { is_highlander: true, per_page: 3 });

      // Loading
      this.loading = false
    },
  },
})
