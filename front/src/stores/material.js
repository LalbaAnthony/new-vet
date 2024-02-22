import { defineStore } from 'pinia'
import { get } from '@/helpers/api';

export const useMaterialStore = defineStore('material', {
  state: () => ({
    material: {
      loading: false,
      data: {},
    },
    materials: {
      loading: false,
      data: [],
    },
  }),

  actions: {
    async fetchMaterials() {
      // Loading
      this.materials.loading = true

      // Data
      this.materials.data = []

      const resp = await get('materials');
      this.materials.data = resp.data;

      // Loading
      this.materials.loading = false
    },

    async fetchMaterial(slug) {
      // Loading
      this.material.loading = true

      // Data
      this.material.data = {}

      const resp = await get('material', { slug: slug, per_page: 1 });
      this.material.data = resp.data;

      // Loading
      this.material.loading = false
    },
  },
})
