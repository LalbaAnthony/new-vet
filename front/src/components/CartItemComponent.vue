<template>
  <div class="cart-item">
    <img
      :src="props.product.images[0]?.image_path && imageExists(URL_BACKEND_UPLOAD + props.product.images[0].image_path) ? `${URL_BACKEND_UPLOAD}${props.product.images[0].image_path}` : '/helpers/no-img-available.webp'"
      :alt="`Image de ${props.product.name}`" />
    <h3 class="cart-item-name">{{ props.product.name }}</h3>
    <div class="cart-item-actions">
      <select v-if="props.product.stock_quantity > 0" v-model="authStore.cart[props.product.slug]">
        <option v-for="qty in props.product.stock_quantity" :key="qty" :value="qty">{{ qty }}</option>
      </select>
      <h3 class="cart-item-price">{{ props.product.price }} €</h3>
      <IconTrash class="cart-item-delete-icon" @click="authStore.removeFromCart(props.product.slug)" />
    </div>
  </div>
</template>

<script setup>
import { imageExists } from '@/helpers/helpers.js'
import IconTrash from '@/components/icons/IconTrash.vue'
import { URL_BACKEND_UPLOAD } from '@/config';
import { useAuthStore } from '@/stores/auth'

const authStore = useAuthStore()

const props = defineProps({
  product: {
    type: Object,
    required: true,
  },
})
</script>

<style scoped>
.cart-item {
  color: var(--dark);
  overflow: hidden;
  background-color: var(--light);
  padding: 2rem;
  box-shadow: 5px 5px 15px 5px rgba(0, 0, 0, 0.1);
  border-radius: 25px;
  display: flex;
  flex-direction: row;
  justify-content: space-between;
  align-items: center;
  gap: 1rem;
}

.cart-item>img {
  height: 75px;
  object-position: left center;
  object-fit: cover;
  transition: all 0.2s ease-in-out;
}


h3.cart-item-name {
  font-size: 1rem;
  line-height: 1.2;
  font-weight: 600;
}

.cart-item-actions {
  display: flex;
  flex-direction: row;
  justify-content: end;
  align-items: center;
  gap: 1rem;
}

h3.cart-item-price {
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
