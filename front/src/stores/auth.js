import { defineStore } from 'pinia'
import { notify } from '@/helpers/notif.js'
import router from '@/router';

export const useAuthStore = defineStore('auth',
  {
    persist: true,
    state: () => ({
      authenticated: false,
      customer: {},
      cart: {},
      authModal: {
        type: 'forgotPassword',
        show: false,
      },
      allModals: {
        'login': {
          title: 'Connexion',
          component: 'AuthLogin',
        },
        'register': {
          title: 'Inscription',
          component: 'AuthRegister',
        },
        'forgotPassword': {
          title: 'Mot de passe oublié',
          component: 'AuthForgotPassword',
        },
        'resetPassword': {
          title: 'Confirmation',
          component: 'AuthResetPassword',
        },
      }
    }),

    actions: {
      logout(redirect = '/') {
        this.authenticated = false
        this.customer = {}
        if (redirect) {
          router.push(redirect)
        }
      },

      toggleModal(el = 'login') {
        this.authModal.type = el;
        this.authModal.show = !this.authModal.show;
      },

      setModal(el) {
        this.authModal.type = el;
        this.authModal.show = true;
      },

      clearCart() {
        this.cart = {};
        notify('Panié vidé !', 'success');
      },

      removeFromCart(productSlug) {
        delete this.cart[productSlug];
        notify('Produit retiré du panier !', 'success');
      },

      addToCart(productSlug, quantity) {
        if (this.cart[productSlug]) {
          this.cart[productSlug] += quantity;
        } else {
          this.cart[productSlug] = quantity;
        }

        const pWord = quantity > 1 ? 'produits' : 'produit';
        const addWord = quantity > 1 ? 'ajoutés' : 'ajouté';
        notify(`${quantity} ${pWord} ${addWord} au panier !`, 'success');
      },

      buyNow(productSlug, quantity) {
        this.addToCart(productSlug, quantity);
        router.push('/panier');
      }
    },
    getters: {
      cartSize() {
        return Object.keys(this.cart).length;
      },
      cartTotal() {
        return Object.values(this.cart).reduce((acc, curr) => acc + curr, 0);
      },
    }
  },
)