import { defineStore } from 'pinia'
import { useToast } from 'vue-toastification'; 

const toast = useToast();

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
      toast.success('Panier vidé !', {
        position: 'top-right',
        timeout: 5000,
        closeOnClick: true,
        pauseOnHover: true,
        draggable: true,
        draggablePercent: 0.6,
        showCloseButtonOnHover: false,
        hideProgressBar: true,
        closeButton: 'button',
        icon: true,
        rtl: false
      });
    }
  },
})
