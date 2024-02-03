<template>
  <div>
    <h2 class="page-title">Votre panier</h2>
    <Loader v-if="productStore.cartProducts.loading" />
    <div v-else>
      <div v-if="productStore.cartProducts.data && productStore.cartProducts.data.length > 0">
        <div class="cart-actions">
          <button class="button" @click="router.push(`/paiment`)">Acheter</button>
          <button @click="authStore.clearCart()" class="button danger">Vider</button>
        </div>
        <div class="products-grid">
          <CartItem v-for="product in productStore.cartProducts.data" :key="product.slug" :product="product"
            @reload-cart="productStore.fetchCartProducts()" />
        </div>
        <MoreProducts
          v-if="productStore.cartProducts.data[0].categories && productStore.cartProducts.data[0].categories.length > 0"
          :category="productStore.cartProducts.data[0].categories[0].slug" />
      </div>
      <NoItem v-else />
    </div>
  </div>
</template>

<script setup>
import CartItem from '@/components/CartItemComponent.vue'
import NoItem from '@/components/NoItemComponent.vue'
import Loader from '@/components/LoaderComponent.vue'
import MoreProducts from '@/components/MoreProductsComponent.vue'
import router from '@/router';
import { useAuthStore } from '@/stores/auth'
import { useProductStore } from '@/stores/product'

const authStore = useAuthStore()
const productStore = useProductStore()

if (authStore.cart) productStore.fetchCartProducts()

</script>

<style scoped>
.cart-actions {
  display: flex;
  justify-content: end;
  margin-bottom: 2rem;
  gap: 0.5rem;
}

.cart-grid {
  display: row;
  grid-template-rows: repeat(1, 1fr);
}
</style>

