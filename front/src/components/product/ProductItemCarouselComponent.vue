<template>
  <router-link :to="`/produits/${props.product.slug}`">
    <div class="product">
      <img
        :src="props.product.images[0]?.path && imageExists(URL_BACKEND_UPLOAD + props.product.images[0].path) ? `${URL_BACKEND_UPLOAD}${props.product.images[0].path}` : '/helpers/no-img-available.webp'"
        :alt="props.product.images[0]?.alt || `Image de ${props.product.name}`" />
      <div>
        <h3 class="product-name">{{ props.product.name }}</h3>
      </div>
    </div>
  </router-link>
</template>

<script setup>
import { imageExists } from '@/helpers/helpers.js'
import { URL_BACKEND_UPLOAD } from '@/config';

const props = defineProps({
  product: {
    type: Object,
    required: true,
  },
})
</script>

<style scoped>
/* MOBILE */
@media (max-width: 767px) {
  .product {
    padding-bottom: 2rem;
    margin-bottom: 3rem;
    border-bottom: 2px solid #eaeaea;
  }
}

.product {
  color: var(--dark);
  background-color: var(--light);
  cursor: pointer;
  overflow: hidden;
  border-radius: 10px;
}

.product>img {
  width: 100%;
  height: 200px;
  object-position: center;
  object-fit: cover;
  transition: all 0.2s ease-in-out;
  border-radius: 10px;
}

.product:hover>img {
  transform: scale(1.05);
}

h3.product-name {
  font-size: 1rem;
  line-height: 1.2;
  font-weight: 600;
  margin-top: 0.5rem;
}
</style>
