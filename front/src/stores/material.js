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
      pagination: { page: 1, per_page: 10, total: 1 },
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

      const resp = await get('material', { slug: slug });
      this.material.data = resp.data[0];

      // Loading
      this.material.loading = false
    },
  },
})
