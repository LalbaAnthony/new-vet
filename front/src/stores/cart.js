import { defineStore } from 'pinia'
import { useToast } from 'vue-toastification'; // ? https://blog.logrocket.com/selecting-best-vue-3-toast-notification-library/ https://vue-toastification.maronato.dev/

const toast = useToast();

export const useCartStore = defineStore('cart', {
  state: () => ({
    cart: {},
  }),

  actions: {
    clearCart() {
      this.cart = {};
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
