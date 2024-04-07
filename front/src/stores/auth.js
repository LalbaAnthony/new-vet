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
        type: 'login',
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

      async validateToken() {

        if (!this.authenticated) {
          router.push('/')
          return;
        }

        await get('customer/validate_token', { email: this.user.email, token: this.token || this.user.connection_token }).then(resp => {

          if (resp.error) {
            this.logout()
            notify(`Une erreur est survenue: ${resp.error}`, 'error');
            return;
          }

          if (!resp.data[0].token_ok) {
            this.logout()
            return;
          }

        }).catch(error => {
          this.logout()
          notify(`Une erreur est survenue: ${error}`, 'error');
          return;
        });
      },

      async getUserInfos() {

        if (!this.authenticated) {
          return;
        }

        await get('customer/infos', { email: this.user.email, token: this.token || this.user.connection_token }).then(resp => {

          if (resp.error) {
            notify(`Une erreur est survenue: ${resp.error}`, 'error');
            return;
          }

          this.user = resp.data[0]
          this.token = resp.data[0].connection_token
          this.authenticated = true
        }).catch(error => {
          notify(`Une erreur est survenue: ${error}`, 'error');
          return;
        });
      },

      async changePassword(oldPassword, newPassword) {

        let missing_fields = [];
        if (!oldPassword) missing_fields.push('Ancien mot de passe');
        else oldPassword = oldPassword.trim();
        if (!newPassword) missing_fields.push('Nouveau mot de passe');
        else newPassword = newPassword.trim();

        if (missing_fields.length > 0) {
          notify(`Veuillez renseigner les champs suivants: ${missing_fields.join(', ')}`, 'error');
          return;
        }

        await post('customer/change_password', { email: this.user.email, old_password: oldPassword, new_password: newPassword, token: this.token || this.user.connection_token}).then(resp => {

          if (resp.error) {
            notify(`Une erreur est survenue: ${resp.error}`, 'error');
            return;
          }

          notify(`Votre mot de passe a été modifié avec succès !`, 'success');
        }).catch(error => {
          notify(`Une erreur est survenue: ${error}`, 'error');
          return;
        });
      },

      async register(user, redirect = '/') {

        let missing_fields = [];
        if (!user.first_name) missing_fields.push('Prénom');
        else user.first_name = user.first_name.trim();
        if (!user.last_name) missing_fields.push('Nom');
        else user.last_name = user.last_name.trim();
        if (!user.email) missing_fields.push('Email');
        else user.email = user.email.trim();
        if (!user.password) missing_fields.push('Mot de passe');
        else user.password = user.password.trim();
        if (!user.collect_data) missing_fields.push('Accepter les conditions');

        if (missing_fields.length > 0) {
          notify(`Veuillez renseigner les champs suivants: ${missing_fields.join(', ')}`, 'error');
          return;
        }

        await post('customer/register', { customer: user }).then(resp => {

          if (resp.error) {
            notify(`Une erreur est survenue: ${resp.error}`, 'error');
            return;
          }

          this.authenticated = false
          this.authModal.show = true
          this.authModal.type = 'login'

          notify(`Vous vous êtes inscrit avec succès !`, 'success');
        }).catch(error => {
          this.authenticated = false
          notify(`Une erreur est survenue: ${error}`, 'error');
          return;
        });

        if (redirect) {
          router.push(redirect)
        }
      },

      async login(email, password, redirect = '/') {

        if (!email || !password) {
          notify('Veuillez renseigner votre email et mot de passe', 'error');
          return;
        }

        if (email) email = email.trim();
        if (password) password = password.trim();

        await get('customer/login', { password, email }).then(resp => {

          if (resp.error) {
            notify(`Une erreur est survenue: ${resp.error}`, 'error');
            return;
          }

          this.user = resp.data[0]
          this.token = resp.data[0].connection_token
          this.authenticated = true
          this.authModal.show = false
          notify(`${hello()} ! Vous êtes maintenant connecté`, 'success');
        }).catch(error => {
          this.authenticated = false
          notify(`Une erreur est survenue: ${error}`, 'error');
          return;
        });

        if (redirect) {
          router.push(redirect)
        }
      },

      logout(redirect = '/') {

        this.authenticated = false
        this.authModal.show = false

        this.user = {}
        if (redirect) {
          router.push(redirect)
        }
        notify('Vous avez été déconnecté !', 'info');
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