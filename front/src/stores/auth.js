import { defineStore } from 'pinia'
import { get, post } from '@/helpers/api';
import { notify } from '@/helpers/notif.js'
import { hello } from '@/helpers/helpers.js'
import router from '@/router';

export const useAuthStore = defineStore('auth',
  {
    persist: true,
    state: () => ({
      authenticated: false,
      token: null,
      user: {},
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

        let missing_fields = [];
        if (!user.first_name) missing_fields.push('Prénom');
        if (!user.last_name) missing_fields.push('Nom');
        if (!user.email) missing_fields.push('Email');
        if (!user.password) missing_fields.push('Mot de passe');
        if (!user.collect_data) missing_fields.push('Accepter les conditions');
        
        if (missing_fields.length > 0) {
          notify(`Veuillez renseigner les champs suivants: ${missing_fields.join(', ')}`, 'error');
          return;
        }
        
        if (user.first_name) user.first_name = user.first_name.trim();
        if (user.last_name) user.last_name = user.last_name.trim();
        if (user.email) user.email = user.email.trim();
        if (user.password) user.password = user.password.trim();

        const resp = await post('customer/register', { customer: user });

        if (resp.error) {
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

      async login(email, password, redirect = '/') {

        if (!email || !password) {
          notify('Veuillez renseigner votre email et mot de passe', 'error');
          return;
        }

        if (email) email = email.trim();
        if (password) password = password.trim();

        const resp = await get('customer/login', { password, email });

        if (resp.error) {
          notify(`Une erreur est survenue: ${resp.error}`, 'error');
          return;
        }
        
        this.user = resp.data[0]
        this.token = resp.data[0].token
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

        this.user = {}
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