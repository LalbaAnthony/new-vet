import { defineStore } from 'pinia'
import { get } from '@/helpers/api';

export const useProductStore = defineStore('product', {
  state: () => ({
    product: {},
    products: [],
    morePorducts: [],
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

      const resp = await get('products', { slug: slug, per_page: 1 });
      this.product = resp[0];

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
        order_by: 'sort_order',
        order_direction: 'asc',
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

    async fetchMoreProducts(categorySlug) {
      // Loading
      this.loading = true

      // Data
      this.morePorducts = []

      this.morePorducts = await get('products', { categories: [categorySlug], per_page: 3, exclude: [this.product.id]});

      // Loading
      this.loading = false
    }
  },
})
