
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
      cards: {
        loading: false,
        data: [],
      },
      addresses: {
        loading: false,
        data: [],
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

      async fetchCards(givenParams = {}) {

        // Loading
        this.cards.loading = true

        // Data
        this.cards.data = []

        // Request
        const params = {
          customer_id: this.user.customer_id,
          token: this.token || this.user.connection_token,
        }

        Object.assign(params, givenParams)

        const resp = await get('customer/cards', params);
        this.cards.data = resp.data || [];

        // Loading
        this.cards.loading = false
      },

      async deleteCard(card_id) {

        if (card_id.length > 0) {
          notify(`Veuillez renseigner l'ID de la carte`, 'error');
          return false;
        }

        post('customer/card-delete', { card_id, customer_id: this.user.customer_id, token: this.token || this.user.connection_token }).then(resp => {
          if (resp.error) {
            notify(resp.error, 'error');
            return false;
          }

          // Delete in local
          this.cards.data = this.cards.data.filter(card => card.card_id !== card_id);

          notify(`La carte a été supprimée avec succès !`, 'success');

          return true;
        }).catch(error => {
          notify(`Une erreur est survenue: ${error}`, 'error');
          return false;
        });
      },

      async addCard(card) {

        let missing_fields = [];
        if (!card.first_name) missing_fields.push('Prénom')
        if (!card.last_name) missing_fields.push('Nom de famille')
        if (!card.number) missing_fields.push('Numéro de carte')
        if (!card.expiration_date) missing_fields.push('Date d\'expiration')
        if (!card.cvv) missing_fields.push('CVV')

        if (missing_fields.length > 0) {
          notify(`Veuillez renseigner les champs suivants: ${missing_fields.join(', ')}`, 'error');
          return false;
        }

        post('customer/card-add', {
          first_name: card.first_name,
          last_name: card.last_name,
          number: card.number,
          expiration_date: card.expiration_date,
          cvv: card.cvv,
          customer_id: this.user.customer_id,
          token: this.token || this.user.connection_token
        }).then(resp => {
          if (resp.error) {
            notify(resp.error, 'error');
            return false;
          }

          notify(`La carte a été ajoutée avec succès !`, 'success');

          return true;
        }).catch(error => {
          notify(`Une erreur est survenue: ${error}`, 'error');
          return false;
        });
      },

      async fetchAddresses(givenParams = {}) {

        // Loading
        this.addresses.loading = true

        // Data
        this.addresses.data = []

        // Request
        const params = {
          customer_id: this.user.customer_id,
          token: this.token || this.user.connection_token,
        }

        Object.assign(params, givenParams)

        const resp = await get('customer/addresses', params);
        this.addresses.data = resp.data || [];

        // Loading
        this.addresses.loading = false
      },

      async deleteAddress(address_id) {

        if (address_id.length > 0) {
          notify(`Veuillez renseigner l'ID de l'adresse`, 'error');
          return false;
        }

        post('customer/address-delete', { address_id, customer_id: this.user.customer_id, token: this.token || this.user.connection_token }).then(resp => {
          if (resp.error) {
            notify(resp.error, 'error');
            return false;
          }

          // Delete in local
          this.addresses.data = this.addresses.data.filter(address => address.address_id !== address_id);

          notify(`L'adresse a été supprimée avec succès !`, 'success');

          return true;
        }).catch(error => {
          notify(`Une erreur est survenue: ${error}`, 'error');
          return false;
        });
      },

      async addAddress(address) {

        let missing_fields = [];

        if (!address.first_name) missing_fields.push('Prénom')
        if (!address.last_name) missing_fields.push('Nom de famille')
        if (!address.address1) missing_fields.push('Adresse 1')
        if (!address.city) missing_fields.push('Ville')
        if (!address.region) missing_fields.push('Région')
        if (!address.zip) missing_fields.push('Code postal')
        if (!address.country_id) missing_fields.push('Pays')
        if (!address.tel) missing_fields.push('Téléphone')

        if (missing_fields.length > 0) {
          notify(`Veuillez renseigner les champs suivants: ${missing_fields.join(', ')}`, 'error');
          return false;
        }

        post('customer/address-add', {
          first_name: address.first_name,
          last_name: address.last_name,
          address1: address.address1,
          address2: address.address2,
          city: address.city,
          region: address.region,
          zip: address.zip,
          country_id: address.country_id,
          tel: address.tel,
          customer_id: this.user.customer_id,
          token: this.token || this.user.connection_token
        }).then(resp => {
          if (resp.error) {
            notify(resp.error, 'error');
            return false;
          }

          notify(`L'adresse a été ajoutée avec succès !`, 'success');

          return true;
        }).catch(error => {
          notify(`Une erreur est survenue: ${error}`, 'error');
          return false;
        });
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