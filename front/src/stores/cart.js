import { defineStore } from 'pinia'

export const useCartStore = defineStore('cart', {
  state: () => ({
    cart: {},
  }),

  actions: {
    clearCart() {
      this.cart = {};
    }
  },
})
