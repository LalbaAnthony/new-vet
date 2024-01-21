import { defineStore } from 'pinia'
import { notify } from '@/helpers/notif.js'

export const useAuthStore = defineStore('auth', {
  state: () => ({
    authenticated: false,
    user: null,
    cart: [],
    showForgotPasswordModal: false,
    showResetPasswordModal: false,
  }),

  actions: {
    clearCart() {
      this.cart = [];
      notify('Panié vidé !', 'success');
    }
  },
})
