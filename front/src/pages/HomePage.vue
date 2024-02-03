<template>
  <div>
    <Carousel title="Notre séléction de produits" :items="productStore.data.highlandersProducts" :autoplay="false" />
  </div>
</template>

<script setup>
import Carousel from '@/components/CarouselComponent.vue'
import { useProductStore } from '@/stores/product'

const productStore = useProductStore()

productStore.fetchHighlandersProducts()

</script>

<style scoped></style>
