<template>
  <div v-if="props.type && props.items && props.items.length > 0">
    <h3 v-if="props.title" class="section-title">{{ props.title }}</h3>
    <carousel :items-to-show="mobile ? 1 : 2.5" :autoplay="props.autoplay ? 3000 : 0"
      :loop="props.autoplay ? true : false" :transition="500">

      <slide v-for="item in props.items" :key="item.id" @click.stop="router.push(item.link)">
        <CategoryCarousel v-if="props.type === 'category'" :category="item" />
        <ProductCarousel v-else-if="props.type === 'product'" :product="item" />
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
import CategoryCarousel from '@/components/category/CategoryItemCarouselComponent.vue'
import ProductCarousel from '@/components/product/ProductItemCarouselComponent.vue'
import { Carousel, Slide, Pagination, Navigation } from 'vue3-carousel'
import { isMobile } from '@/helpers/helpers.js'
import router from '@/router';

const mobile = isMobile()

const props = defineProps({
  type: {
    type: String,
    possibleValues: ['product', 'category'],
    required: true,
  },
  title: {
    type: String,
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