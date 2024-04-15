import { defineStore } from 'pinia'
import { get } from '@/helpers/api';

export const useStatusStore = defineStore('status', {
  state: () => ({
      statuses: {
      loading: false,
      data: [],
    },
  }),

  actions: {
    async fetchStatuses() {
      // Loading
      this.statuses.loading = true

      // Data
      this.statuses.data = []

      const resp = await get('statuses');
      this.statuses.data = resp.data || [];

      // Loading
      this.statuses.loading = false
    },
  },
})
