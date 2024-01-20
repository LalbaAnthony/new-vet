<template>
  <section v-if="products && products.length > 0">
    <h3 class="section-title">{{ title }}</h3>

    <carousel :items-to-show="mobile ? 1 : 2.5" :autoplay="autoplay" :loop="autoplay ? true : false">
      <slide v-for="product in products" :key="product.slug">
        <Product :product="product" />
      </slide>

      <template #addons>
        <navigation v-if="!mobile" />
        <pagination />
      </template>
    </carousel>

  </section>
</template>

<script setup>
import 'vue3-carousel/dist/carousel.css'
import { Carousel, Slide, Pagination, Navigation } from 'vue3-carousel'
import Product from '@/components/ProductComponent.vue'
import { isMobile } from '@/helpers/helpers.js'

const mobile = isMobile()

defineProps({
  title: {
    type: String,
    default: 'Nos produits',
    required: false,
  },
  products: {
    type: Array,
    required: true,
  },
  autoplay: {
    type: Int16Array,
    default: 3000,
    required: false,
  },
})
</script>

<style scoped>

.carousel {
  width: 100%;
  height: 100%;
}

.carousel__viewport {
  overflow: visible !important
}

.carousel__slide--visible {
  margin: 0 1rem;
  transition: transform 0.5s ease-in-out;
  filter: grayscale(100%);
}


/* Slides style */
/* .carousel__slide--prev {} */


.carousel__slide--active {
  filter: none;
}


/* .carousel__slide--next {} */

/* Nav buttons */
button.carousel__prev {
  background-color: red;
}

/* button.carousel__next {} */

/* Current pagination element */
.carousel__pagination-button--active::after {
  background-color: red;
}
</style>