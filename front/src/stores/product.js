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
      pagination: { page: 1, per_page: 10, total: 1 },
    },
    moreProducts: {
      loading: false,
      data: {},
    },
    highlandersProducts: {
      loading: false,
      data: [],
    },
    cartProducts: {
      loading: false,
      data: [],
    },
  }),

  actions: {
    changePage(page) {
      this.products.pagination.page = page
      this.fetchProducts()
    },

    async fetchProduct(slug) {
      // Loading
      this.product.loading = true

      // Data
      this.product.data = {}

      const resp = await get('product', { slug: slug, per_page: 1 });
      this.product.data = resp.data[0];

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
        page: this.products.pagination.page || 1,
        per_page: this.products.pagination.per_page || 10,
        sort: [
          { order: 'ASC', order_by: 'sort_order' },
          { order: 'DESC', order_by: 'stock_quantity' }
        ],
      }

      Object.assign(params, givenParams)

      const resp = await get('products', params);
      this.products.data = resp.data;
      this.products.pagination = resp.pagination;
      
      // Loading
      this.products.loading = false
    },

    async fetchHighlandersProducts() {
      // Loading
      this.highlandersProducts.loading = true

      // Data
      this.highlandersProducts.data = []

      const resp = await get('products', { is_highlander: true, per_page: 3 });
      this.highlandersProducts.data = resp.data;

      // Loading
      this.highlandersProducts.loading = false
    },

    async fetchMoreProducts(categorySlug) {
      // Loading
      this.moreProducts.loading = true

      // Data
      this.moreProducts.data[categorySlug] = []

      const resp = await get('products', { categories: [categorySlug], per_page: 6, exclude: [this.product.data.slug] });
      this.moreProducts.data[categorySlug] = resp.data;

      // Loading
      this.moreProducts.loading = false
    },

    async fetchCartProducts() {
      // Loading
      this.cartProducts.loading = true

      // Data
      this.cartProducts.data = []

      const productSlugs = Object.keys(authStore.cart);
      if (productSlugs.length) {
        const resp = await get('products', { include: [productSlugs.join(',')] });
        this.cartProducts.data = resp.data;
      } else {
        this.cartProducts.data = [];
      }

      // Loading
      this.cartProducts.loading = false
    }
  },
  getters: {
    cartProductsTotalPrice() {
      return this.cartProducts.data.reduce((acc, curr) => {
        return acc + (curr.price * authStore.cart[curr.slug]);
      }, 0);
    }
  }
})
