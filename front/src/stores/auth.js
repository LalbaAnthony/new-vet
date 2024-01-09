import { defineStore } from 'pinia'
import { useToast } from 'vue-toastification'; // ? https://blog.logrocket.com/selecting-best-vue-3-toast-notification-library/ https://vue-toastification.maronato.dev/

const toast = useToast();

export const useAuthStore = defineStore('auth', {
  state: () => ({
    authenticated: false,
    user: null,
    showForgotPasswordModal: false,
    showResetPasswordModal: false,
  }),

  actions: {

  },
})
