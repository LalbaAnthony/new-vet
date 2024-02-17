<template>
  <div v-if="props.items && props.items.length > 0">
    <h3 class="section-title">{{ props.title }}</h3>
    <carousel :items-to-show="mobile ? 1 : 2.5" :autoplay="props.autoplay ? 3000 : 0"
      :loop="props.autoplay ? true : false" :transition="500">

      <slide v-for="item in props.items" :key="item.id" @click.stop="router.push(item.link)">
        <img
          :src="item?.path && imageExists(URL_BACKEND_UPLOAD + item.path) ? `${URL_BACKEND_UPLOAD}${item.path}` : '/helpers/no-img-available.webp'"
          :alt="`Image ${item.name || item.libelle}`" class="carousel-img" />
      </slide>
      <template #addons>
        <navigation v-if="!mobile" />
        <pagination />
      </template>
    </carousel>

  </div>
</template>

<script setup>
import 'vue3-carousel/dist/carousel.css'
import { Carousel, Slide, Pagination, Navigation } from 'vue3-carousel'
import { imageExists } from '@/helpers/helpers.js'
import { URL_BACKEND_UPLOAD } from '@/config';
import { isMobile } from '@/helpers/helpers.js'
import router from '@/router';

const mobile = isMobile()

const props = defineProps({
  title: {
    type: String,
    default: 'Nos produits',
    required: false,
  },
  items: {
    type: Array,
    required: true,
  },
  autoplay: {
    type: Boolean,
    default: true,
    required: false,
  },
})
</script>

<style scoped>
img.carousel-img {
  width: 100%;
  height: 200px;
  object-position: center;
  object-fit: cover;
  transition: all 0.2s ease-in-out;
}

img.carousel-img:hover {
  transform: scale(1.05);
  cursor: pointer;
}

.carousel {
  width: 100%;
  height: 100%;
}

.carousel__slide--visible {
  margin: 0 1rem;
  transition: transform 0.5s ease-in-out;
}
</style>