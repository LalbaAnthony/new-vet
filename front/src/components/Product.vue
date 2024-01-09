<template>
  <router-link :to="`produits/${product.slug}`">
    <div class="product">
      <img :src="product.image ? product.image : 'public/helpers/no-img-available.webp'"
        :alt="`Image de ${product.title}`" />
      <div>
        <div class="product-categories">
          <Pill v-for="cat in product.categories" :key="cat.slug" :text="cat.libelle" :link="`categories/${cat.slug}`" />
        </div>
        <h3 class="product-title">{{ product.title }}</h3>
        <p class="product-text">{{ threeDotString(product.text) }}</p>
      </div>
    </div>
  </router-link>
</template>

<script setup>
import { threeDotString } from '@/helpers/helpers.js'
import Pill from '@/components/Pill.vue'

defineProps({
  product: {
    type: Object,
    required: true,
  },
})
</script>

<style scoped>
.product {
  color: var(--dark);
  background-color: var(--light);
  border: var(--light) 1px solid;
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

h3.product-title {
  font-size: 1rem;
  line-height: 1.2;
  font-weight: 600;
  margin-top: 0.5rem;
}

p.product-text {
  padding: 0.5rem 0;
}
</style>
