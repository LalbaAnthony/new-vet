<template>
  <div>
    <h2 class="page-title">Votre panier</h2>
    <Breadcrumb />
    <Loader v-if="productStore.cartProducts.loading" />
    <div v-else>
      <div v-if="productStore.cartProducts.data && productStore.cartProducts.data.length > 0">
        <div class="cart-infos">
          <span class="cart-total-price">Total: {{ roundNb(productStore.cartProductsTotalPrice) }} €</span>
          <div class="cart-actions">
            <button class="button" @click="handleBuy()">Acheter</button>
            <button @click="authStore.clearCart();reloadProductStoreCart()" class="button danger">Vider</button>
          </div>
        </div>
        <div class="products-grid">
          <CartItem v-for="product in productStore.cartProducts.data" :key="product.slug" :product="product"
            @reload-cart="reloadProductStoreCart()" />
        </div>
        <MoreProducts
          v-if="productStore.cartProducts.data[0].categories && productStore.cartProducts.data[0].categories.length > 0"
          :category="productStore.cartProducts.data[0].categories[0].slug" title="En rapport avec votre panier" />
      </div>
      <NoItem :cta="{ text: 'Liste des produits', to: '/produits' }" v-else />
    </div>
  </div>
</template>

<script setup>
import Breadcrumb from '@/components/BreadcrumbComponent.vue'
import CartItem from '@/components/cart/CartItemComponent.vue'
import NoItem from '@/components/NoItemComponent.vue'
import Loader from '@/components/LoaderComponent.vue'
import MoreProducts from '@/components/MoreProductsComponent.vue'
import router from '@/router';
import { useAuthStore } from '@/stores/auth'
import { useProductStore } from '@/stores/product'
import { roundNb } from '@/helpers/helpers.js'

const authStore = useAuthStore()
const productStore = useProductStore()

if (authStore.cart) reloadProductStoreCart()

function reloadProductStoreCart() {
  productStore.fetchCartProducts()
}

function handleBuy() {
  if (authStore.authenticated) {
    router.push('/passer-commande')
  } else {
    authStore.toggleModal()
  }
}

</script>

<style scoped>
.cart-infos {
  display: flex;
  justify-content: space-between;
  gap: 0.5rem;
  align-items: center;
  margin-bottom: 2rem;
}

.cart-infos .cart-total-price {
  font-size: 1.25rem;
  font-weight: bold;
  color: var(--dark);
}

.cart-actions {
  display: flex;
  justify-content: end;
  align-items: center;
  gap: 0.5rem;
}

.cart-grid {
  display: row;
  grid-template-rows: repeat(1, 1fr);
}
</style>

