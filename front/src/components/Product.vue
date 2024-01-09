<template>
  <router-link :to="`actualites/${product.slug}`">
    <div class="product">
      <img :src="product.image ? product.image : 'public/helpers/no-img-available.webp'" :alt="`Image de ${product.title}`" />
      <div class="product-content">
        <span v-if="product.category" class="pill">{{ product.category }}</span>
        <h3 class="product-title">{{ product.title }}</h3>
        <p class="product-text">{{ threeDotString(product.text) }}</p>
      </div>
      <IconArrowRight class="following-arrow" />
    </div>
  </router-link>
</template>

<script setup>
import IconArrowRight from '@/components/icons/IconArrowRight.vue'
import { threeDotString } from '@/helpers/helpers.js'

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
  border-radius: 10px;
  border: var(--light) 1px solid;
  box-shadow: 2px 2px 2px rgba(0, 0, 0, 0.2);
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

.product-content {
  padding: 1rem;
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

.following-arrow {
  margin: 1rem 2rem;
  float: right;
  color: var(--primary);
  width: 2rem;
  height: 2rem;
  transition: all 0.2s ease-in-out;
}

.product:hover>.following-arrow {
  transform: translateX(1rem);
}
</style>
