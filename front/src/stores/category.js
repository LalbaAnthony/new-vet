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

      const resp = await get('categories', { slug: slug, per_page: 1 });
      this.category = resp[0];

      // Loading
      this.loading = false
    },
  },
})
