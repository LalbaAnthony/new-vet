<template>
  <router-link :to="{ path: '/produits', query: { categories: props.category.slug } }">
    <div class="category-item">
      <img
        :src="props.category?.image?.path && imageExists(BACKEND_UPLOAD_URL + props.category.image.path) ? `${BACKEND_UPLOAD_URL}${props.category.image.path}` : '/helpers/no-img-available.webp'"
        :alt="props.category.image.alt || `Image de ${props.category.libelle}`" />
      <h2 class="category-item-libelle">{{ props.category.libelle }}</h2>
    </div>
  </router-link>
</template>

<script setup>
import { imageExists } from '@/helpers/helpers.js'
import { BACKEND_UPLOAD_URL } from '@/config';

const props = defineProps({
  category: {
    type: Object,
    required: true,
  },
})
</script>

<style scoped>
.category-item {
  border-radius: 25px;
  transition: all 0.3s ease;
  cursor: pointer;
}

.category-item:hover {
  scale: 1.05;
  box-shadow: 10px 10px 10px rgba(0, 0, 0, 0.2);
}

.category-item>img {
  width: 100%;
  border-radius: 25px;
  height: 200px;
  object-fit: cover;
  filter: brightness(50%);
  display: block;
}

.category-item h2 {
  color: var(--light);
  text-transform: uppercase;
  padding: 1rem;
  font-size: 1.5rem;
  font-weight: 700;
}

.category-item-libelle {
  position: absolute;
  transform: translate(0%, -100%);
  transition: all 0.3s ease;
}

.category-item:hover .category-item-libelle {
  transform: translate(10%, -100%);
}
</style>
