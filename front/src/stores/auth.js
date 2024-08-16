
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
      fogotPasswordEmail: null,
      user: {},
      cart: {},
      order: {
        loading: false,
        data: [],
      },
      orders: {
        loading: false,
        data: [],
        pagination: { page: 1, per_page: 5, total: 1 },
      },
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
          return false;
        }

        get('customer/validate-token', { email: this.user.email, token: this.token || this.user.connection_token }).then(resp => {

          if (resp.error) {
            this.logout()
            notify(resp.error, 'error');
            return false;
          }

          if (!resp.data[0].token_ok) {
            this.logout()
            return false;
          }

          return true;
        }).catch(error => {
          this.logout()
          notify(`Une erreur est survenue: ${error}`, 'error');
          return false;
        });
      },

      async getUserInfos() {

        if (!this.authenticated) {
          return false;
        }
        get('customer/infos', { email: this.user.email, token: this.token || this.user.connection_token }).then(resp => {

          if (resp.error) {
            notify(resp.error, 'error');
            return false;
          }

          this.user = resp.data[0]
          this.token = resp.data[0].connection_token
          this.authenticated = true

          return true;
        }).catch(error => {
          notify(`Une erreur est survenue: ${error}`, 'error');
          return false;
        });
      },

      async verifyEmail(email, token) {

        if (!email || !token) {
          notify('Veuillez renseigner votre e-mail et token', 'error');
          return false;
        }

        get('customer/verify-email', { email, token }).then(resp => {

          if (resp.error) {
            notify(resp.error, 'error');
            return false;
          }

          notify(`Votre e-mail a été vérifié avec succès !`, 'success');

          return true;
        }).catch(error => {
          notify(`Une erreur est survenue: ${error}`, 'error');
          return false;
        });
      },

      async forgotPassword(email) {

        if (!email) {
          notify('Veuillez renseigner votre email', 'error');
          return false;
        }

        get('customer/forgot-password', { email }).then(resp => {

          if (resp.error) {
            notify(resp.error, 'error');
            return false;
          }

          notify(`Un code de réinitialisation vous a été envoyé par e-mail !`, 'success');

          return true;
        }).catch(error => {
          notify(`Une erreur est survenue: ${error}`, 'error');
          return false;
        });
      },

      async resetPassword(code, newPassword, email = this.fogotPasswordEmail) {

        let missing_fields = [];
        if (!email) missing_fields.push('Email');
        else email = email.trim();
        if (!code) missing_fields.push('code');
        if (!newPassword) missing_fields.push('Nouveau mot de passe');
        else newPassword = newPassword.trim();

        if (missing_fields.length > 0) {
          notify(`Veuillez renseigner les champs suivants: ${missing_fields.join(', ')}`, 'error');
          return false;
        }

        post('customer/reset-password', { email, code, new_password: newPassword }).then(resp => {

          if (resp.error) {
            notify(resp.error, 'error');
            return false;
          }

          notify(`Votre mot de passe a été réinitialisé avec succès !`, 'success');
          this.setModal('login');

          return true;
        }).catch(error => {
          notify(`Une erreur est survenue: ${error}`, 'error');
          return false;
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
          return false;
        }

        post('customer/change-password', { email: this.user.email, old_password: oldPassword, new_password: newPassword, token: this.token || this.user.connection_token }).then(resp => {

          if (resp.error) {
            notify(resp.error, 'error');
            return false;
          }

          notify(`Votre mot de passe a été modifié avec succès !`, 'success');

          return true;
        }).catch(error => {
          notify(`Une erreur est survenue: ${error}`, 'error');
          return false;
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
          return false;
        }

        post('customer/register', { customer: user }).then(resp => {

          if (resp.error) {
            notify(resp.error, 'error');
            return false;
          }

          this.authenticated = false
          this.authModal.show = true
          this.authModal.type = 'login'

          notify(`Vous vous êtes inscrit avec succès !`, 'success');

          return true;
        }).catch(error => {
          this.authenticated = false
          notify(`Une erreur est survenue: ${error}`, 'error');
          return false;
        });

        if (redirect) {
          router.push(redirect)
        }
      },

      async login(email, password, redirect = '/') {

        if (!email || !password) {
          notify('Veuillez renseigner votre email et mot de passe', 'error');
          return false;
        }

        if (email) email = email.trim();
        if (password) password = password.trim();

        get('customer/login', { password, email }).then(resp => {

          if (resp.error) {
            notify(resp.error, 'error');
            return false;
          }

          this.user = resp.data[0]
          this.token = resp.data[0].connection_token
          this.authenticated = true
          this.authModal.show = false
          notify(`${hello()} ! Vous êtes maintenant connecté`, 'success');

          return true;
        }).catch(error => {
          this.authenticated = false
          notify(`Une erreur est survenue: ${error}`, 'error');
          return false;
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

      addToCart(productSlug, quantity = 1) {
        if (this.cart[productSlug]) {
          this.cart[productSlug] += quantity;
        } else {
          this.cart[productSlug] = quantity;
        }

        const pWord = quantity > 1 ? 'produits' : 'produit';
        const addWord = quantity > 1 ? 'ajoutés' : 'ajouté';
        notify(`${quantity} ${pWord} ${addWord} au panier !`, 'success');
      },

      async fetchOrder(orderId) {
        // Loading
        this.order.loading = true
  
        // Data
        this.order.data = {}
  
        // Request
        const params = {
          customer_id: this.user.customer_id,
          token: this.token || this.user.connection_token,
        }

        Object.assign(params, { order_id: orderId })

        const resp = await get('customer/order', params);
        this.order.data = resp.data[0];
  
        // Loading
        this.order.loading = false
      },
  
      async fetchOrders(givenParams = {}) {
  
        // Loading
        this.orders.loading = true
  
        // Data
        this.orders.data = []
  
        // Request
        const params = {
          customer_id: this.user.customer_id,
          token: this.token || this.user.connection_token,
          page: this.orders.pagination.page || 1,
          per_page: this.orders.pagination.per_page || 5,
          sort: [
            { order: 'DESC', order_by: 'order_date' }
          ],
        }
  
        Object.assign(params, givenParams)
  
        const resp = await get('customer/orders', params);
        this.orders.data = resp.data || [];
        this.orders.pagination = resp.pagination || { page: 1, per_page: 5, total: 1 };
        
        // Loading
        this.orders.loading = false
      },

      ordersChangePage(page) {
        this.orders.pagination.page = page;
        this.fetchOrders();
        window.scrollTo({ top: 0, behavior: 'smooth' });
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