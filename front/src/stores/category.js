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
      pagination: { page: 1, perPage: 8 , total: 0 },
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
    async fetchCategories() {
      // Loading
      this.categories.loading = true

      // Data
      this.categories.data = []

      this.categories.data = await get('categories');

      // Loading
      this.categories.loading = false
    },

    async fetchQuickAccessCategories() {
      // Loading
      this.quickAccessCategories.loading = true

      // Data
      this.quickAccessCategories.data = []

      this.quickAccessCategories.data = await get('categories', { is_quick_access: true });

      // Loading
      this.quickAccessCategories.loading = false
    },

    async fetchHighlandersCategories() {
      // Loading
      this.highlandersCategories.loading = true

      // Data
      this.highlandersCategories.data = []

      this.highlandersCategories.data = await get('categories', { is_highlander: true });

      // Loading
      this.highlandersCategories.loading = false
    },

    async fetchCategory(slug) {
      // Loading
      this.category.loading = true

      // Data
      this.category.data = {}

      const resp = await get('categories', { slug: slug, per_page: 1 });
      this.category.data = resp[0];

      // Loading
      this.category.loading = false
    },
  },
})
