import { defineStore } from 'pinia'
import { get } from '@/helpers/api';

export const useCountryStore = defineStore('country', {
  state: () => ({
    countries: {
      loading: false,
      data: [],
    },
  }),

  actions: {
    async fetchCountries(givenParams = {}) {

      // Loading
      this.countries.loading = true

      // Data
      this.countries.data = []

      // Request
      const params = {}

      Object.assign(params, givenParams)

      const resp = await get('countries', params);
      this.countries.data = resp.data || [];

      // Loading
      this.countries.loading = false
    },
  },
})
