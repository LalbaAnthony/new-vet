import { defineStore } from 'pinia'
import { get } from '@/helpers/api';
import { post } from '@/helpers/api';
import { notify } from '@/helpers/notif.js'
import { hello } from '@/helpers/helpers.js'
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
    }),

    actions: {

      toggleModal(el = 'login') {
        this.authModal.type = el;
        this.authModal.show = !this.authModal.show;
      },

      setModal(type) {
        this.authModal.type = type;
        this.authModal.show = true;
        window.scrollTo({ top: 0, behavior: 'smooth' });
      },

      async register(user, redirect = '/') {
        console.log('registered: ', user);

        let missing_fields = [];
        if (!user.first_name) missing_fields.push('Prénom');
        if (!user.last_name) missing_fields.push('Nom');
        if (!user.country_id) missing_fields.push('Pays');
        if (!user.email) missing_fields.push('Email');
        if (!user.password) missing_fields.push('Mot de passe');

        if (missing_fields.length > 0) {
          notify(`Veuillez renseigner les champs suivants: ${missing_fields.join(', ')}`, 'error');
          return;
        }

        const resp = await post('customer/register', { customer: user });

        if (resp.error || !resp.data) {
          notify(`Une erreur est survenue: ${resp.error}`, 'error');
          return;
        }

        this.authenticated = false
        this.authModal.show = true
        this.authModal.type = 'login'

        if (redirect) {
          router.push(redirect)
        }

        notify(`Vous vous êtes inscrit avec succès !`, 'success');
      },

      login(email, password, redirect = '/') {
        console.log('loged in: ', email, password);

        this.authenticated = true
        this.authModal.show = false

        if (redirect) {
          router.push(redirect)
        }

        notify(`${hello()} ! Vous êtes maintenant connecté`, 'success');
      },

      logout(redirect = '/') {

        this.authenticated = false
        this.authModal.show = false

        this.customer = {}
        if (redirect) {
          router.push(redirect)
        }
        notify('Vous avez été déconnecté !', 'error');
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