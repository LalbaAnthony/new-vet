<template>
  <div>
    <Carousel title="Notre séléction de produits" :items="carouselItems" :autoplay="false" />
  </div>
</template>

<script setup>
import { ref } from 'vue'
import Carousel from '@/components/CarouselComponent.vue'

const carouselItems = ref([
  {
    id: 1,
    image_path: 'https://img.freepik.com/free-photo/smiling-beautiful-young-woman-pink-mini-dress-posing-studio_155003-14602.jpg',
    link: '/produits/product1',
  },
  {
    id: 2,
    image_path: 'https://img.freepik.com/free-photo/smiling-beautiful-young-woman-pink-mini-dress-posing-studio_155003-14602.jpg',
    link: '/produits/product1',
  },
  {
    id: 3,
    image_path: 'https://img.freepik.com/free-photo/smiling-beautiful-young-woman-pink-mini-dress-posing-studio_155003-14602.jpg',
    link: '/produits/product1',
  },
  {
    id: 4,
    image_path: 'https://img.freepik.com/free-photo/smiling-beautiful-young-woman-pink-mini-dress-posing-studio_155003-14602.jpg',
    link: '/produits/product1',
  },
])

</script>

<style scoped></style>
