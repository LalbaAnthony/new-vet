<template>
  <div class="cart-item">
    <img
      :src="props.product.images[0]?.path && imageExists(BACKEND_UPLOAD_URL + props.product.images[0].path) ? `${BACKEND_UPLOAD_URL}${props.product.images[0].path}` : '/helpers/no-img-available.webp'"
      :alt="props.product.images[0]?.alt || `Image de ${props.product.name}`" />
    <h2 class="cart-item-name">{{ props.product.name }}</h2>
    <div class="cart-item-actions">
      <select v-if="props.product.stock_quantity > 0" v-model="authStore.cart[props.product.slug]"
        :disabled="!props.interaction">
        <option v-for="qty in props.product.stock_quantity" :key="qty" :value="qty">{{ qty }}</option>
      </select>
      <span class="cart-item-price">{{ props.product.price }} €</span>
      <IconTrash v-if="props.interaction" class="cart-item-delete-icon"
        @click="authStore.removeFromCart(props.product.slug); $emit('reloadCart')" />
    </div>
  </div>
</template>

<script setup>
import { imageExists } from '@/helpers/helpers.js'
import IconTrash from '@/icons/IconTrash.vue'
import { BACKEND_UPLOAD_URL } from '@/config';
import { useAuthStore } from '@/stores/auth'

const authStore = useAuthStore()

const props = defineProps({
  product: {
    type: Object,
    required: true,
  },
  interaction: {
    type: Boolean,
    default: true,
  },
})
</script>

<style scoped>
/* DESKTOP */
@media (min-width: 1024px) {
  .cart-item {
    flex-direction: row;
  }

  h2.cart-item-name {
    padding: 2rem;
  }

  .cart-item-actions {
    padding: 2rem;
  }

  .cart-item>img {
    height: 100px;
    width: 100px;
    object-position: left center;
    object-fit: cover;
  }
}

/* TABLET */
@media (min-width: 768px) and (max-width: 1023px) {
  .cart-item {
    flex-direction: column;
    padding: 2rem;
  }

  .cart-item>img {
    height: 100px;
    width: 100px;
    border-radius: 50%;
  }
}

/* MOBILE */
@media (max-width: 767px) {
  .cart-item {
    flex-direction: column;
    padding: 2rem;
  }

  .cart-item>img {
    height: 100px;
    width: 100px;
    border-radius: 50%;
  }
}

.cart-item {
  color: var(--dark);
  overflow: hidden;
  background-color: var(--light);
  box-shadow: 3px 3px 15px 3px rgba(0, 0, 0, 0.1);
  border-radius: 15px;
  display: flex;
  justify-content: space-between;
  align-items: center;
  gap: 1rem;
  margin: 1rem 0;
}

h2.cart-item-name {
  font-size: 1.2rem;
  line-height: 1.2;
  font-weight: 700;
}

.cart-item-actions {
  display: flex;
  flex-direction: row;
  justify-content: end;
  align-items: center;
  gap: 2rem;
}

span.cart-item-price {
  font-size: 1.2rem;
  font-weight: 700;
  color: var(--dark);
}

.cart-item-delete-icon {
  background-color: var(--danger);
  border-radius: 50%;
  width: 35px;
  height: 35px;
  padding: 0 0.5rem;
  display: flex;
  color: var(--light);
  transition: all 0.3s;
}

.cart-item-delete-icon:hover {
  transform: scale(1.1);
}
</style>
