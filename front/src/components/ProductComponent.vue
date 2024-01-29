<template>
  <router-link :to="`produits/${product.slug}`">
    <div class="product">
      <img :src="product.images[0]?.image_path ? `${URL_BACKEND_UPLOAD}${product.images[0].image_path}` : 'public/helpers/no-img-available.webp'"
        :alt="`Image de ${product.name}`" />
      <div>
        <div class="product-categories">
          <Pill v-for="cat in product.categories" :key="cat.slug" :text="cat.libelle" :link="`categories/${cat.slug}`" />
        </div>
        <h3 class="product-name">{{ product.name }}</h3>
        <p class="product-description">{{ threeDotString(product.description) }}</p>
        <div class="product-numbers">
          <Stock :stock="product.stock_quantity" />
          <h3 :class="['product-price', product.stock_quantity < 1 ? 'overline' : '']">{{ product.price }} €</h3>
        </div>
      </div>
    </div>
  </router-link>
</template>

<script setup>
import Pill from '@/components/PillComponent.vue'
import Stock from '@/components/StockComponent.vue'
import { threeDotString } from '@/helpers/helpers.js'
import { URL_BACKEND_UPLOAD } from '@/config';

defineProps({
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
    border-bottom: 1px solid #eaeaea;
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

h3.product-price {
  font-size: 1.2rem;
  font-weight: 700;
  color: var(--primary);
}

</style>
