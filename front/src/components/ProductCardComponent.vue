<template>
  <router-link :to="`/produits/${props.product.slug}`">
    <div class="product">
      <img
        :src="props.product.images[0]?.image_path && imageExists(URL_BACKEND_UPLOAD + props.product.images[0].image_path) ? `${URL_BACKEND_UPLOAD}${props.product.images[0].image_path}` : '/helpers/no-img-available.webp'"
        :alt="`Image de ${props.product.name}`" />
      <div>
        <div class="product-categories">
          <Pill v-for="cat in props.product.categories" :key="cat.slug" :text="cat.libelle" :link="`categories/${cat.slug}`" />
        </div>
        <h3 class="product-name">{{ props.product.name }}</h3>
        <p class="product-description">{{ threeDotString(props.product.description) }}</p>
        <div class="product-numbers">
          <Stock :stock="props.product.stock_quantity" />
          <span :class="['product-price', props.product.stock_quantity < 1 ? 'overline' : '']">{{ props.product.price }} €</span>
        </div>
      </div>
    </div>
  </router-link>
</template>

<script setup>
import Pill from '@/components/PillComponent.vue'
import Stock from '@/components/StockComponent.vue'
import { threeDotString } from '@/helpers/helpers.js'
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
}

.product>img {
  width: 100%;
  height: 200px;
  object-position: center;
  object-fit: cover;
  transition: all 0.2s ease-in-out;
}

.product:hover>img {
  transform: scale(1.05);
}

.product-categories {
  display: flex;
  flex-wrap: wrap;
  justify-content: flex-start;
  align-items: center;
}

h3.product-name {
  font-size: 1rem;
  line-height: 1.2;
  font-weight: 600;
  margin-top: 0.5rem;
}

p.product-description {
  padding: 0.5rem 0;
}

.product-numbers {
  display: flex;
  justify-content: space-between;
  align-items: center;
}

span.product-price {
  font-size: 1.2rem;
  font-weight: 700;
  color: var(--primary);
}
</style>
