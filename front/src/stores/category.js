import { defineStore } from 'pinia'
import { get } from '@/helpers/api';

export const useCategoryStore = defineStore('category', {
  state: () => ({
    category: {
      loading: false,
      data: {},
    },
    categories: {
      loading: false,
      data: [],
      pagination: { page: 1, per_page: 10, total: 1 },
    },
    quickAccessCategories: {
      loading: false,
      data: [],
    },
    highlandersCategories: {
      loading: false,
      data: [],
    },
  }),

  actions: {

    changePage(page) {
      this.categories.pagination.page = page
      this.fetchCategories()
      window.scrollTo({ top: 0, behavior: 'smooth' });
    },

    async fetchCategories(givenParams = {}) {

      // Loading
      this.categories.loading = true

      // Data
      this.categories.data = []

      // Request
      const params = {
        page: this.categories.pagination.page || 1,
        per_page: this.categories.pagination.per_page || 10,
        sort: [
          { order: 'ASC', order_by: 'sort_order' },
          { order: 'ASC', order_by: 'libelle' },
        ],
      }

      Object.assign(params, givenParams)

      const resp = await get('categories', params);
      this.categories.data = resp.data || [];
      this.categories.pagination = resp.pagination || { page: 1, per_page: 10, total: 1 };

      // Loading
      this.categories.loading = false
    },

    async fetchQuickAccessCategories() {
      // Loading
      this.quickAccessCategories.loading = true

      // Data
      this.quickAccessCategories.data = []

      const resp = await get('categories', { is_quick_access: true });
      this.quickAccessCategories.data = resp.data

      // Loading
      this.quickAccessCategories.loading = false
    },

    async fetchHighlandersCategories() {
      // Loading
      this.highlandersCategories.loading = true

      // Data
      this.highlandersCategories.data = []

      const resp = await get('categories', { is_highlander: true });
      this.highlandersCategories.data = resp.data

      // Loading
      this.highlandersCategories.loading = false
    },

    async fetchCategory(slug) {
      // Loading
      this.category.loading = true

      // Data
      this.category.data = {}

      const resp = await get('category', { slug: slug });
      this.category.data = resp.data[0]

      // Loading
      this.category.loading = false
    },
  },
})
