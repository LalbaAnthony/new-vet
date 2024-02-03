<template>
  <!-- Redirect to producxts with params -->
  <router-link to="/produits">
    <div class="category-item">
      <img
        :src="props.category.image_path && imageExists(URL_BACKEND_UPLOAD + props.category.image_path) ? `${URL_BACKEND_UPLOAD}${props.category.image_path}` : '/helpers/no-img-available.webp'"
        :alt="`Image de ${props.category.name}`" />
      <h2 class="category-item-libelle">{{ props.category.libelle }}</h2>
    </div>
  </router-link>
</template>

<script setup>
import { imageExists } from '@/helpers/helpers.js'
import { URL_BACKEND_UPLOAD } from '@/config';

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
  box-shadow: 4px 4px 4px rgba(0, 0, 0, 0.2);
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
  transform: translate(0%, -175%);
}
</style>
