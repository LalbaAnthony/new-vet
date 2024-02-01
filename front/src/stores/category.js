import { defineStore } from 'pinia'
import { get } from '@/helpers/api';

export const useCategoryStore = defineStore('category', {
  state: () => ({
    categories: [],
    quickAccessCategories: [],
    loading: false,
  }),

  actions: {
    async fetchCategories() {
      // Loading
      this.loading = true

      // Data
      this.categories = []

      this.categories = await get('categories');

      // Loading
      this.loading = false
    },

    async fetchQuickAccessCategories() {
      // Loading
      this.loading = true

      // Data
      this.quickAccessCategories = []

      this.quickAccessCategories = await get('categories', { is_quick_access: true });

      // Loading
      this.loading = false
    },

    async fetchCategory(slug) {
      // Loading
      this.loading = true

      // Data
      this.category = {}

      this.category = await get(`categories/${slug}`);

      // Loading
      this.loading = false
    },
  },
})
