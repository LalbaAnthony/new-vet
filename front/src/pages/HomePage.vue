<template>
  <div>
    <!-- TODO: Rework Carousel to handle CATEGORIES & PRODUCTS (refacto data before enter in carousel) -->
    <section>
      <Carousel title="Le meilleur de nos produits" :items="productStore.highlandersProducts.data" :autoplay="false" />
    </section>
    <section>
      <Carousel title="Nos catégories préférées" :items="categoryStore.highlandersCategories.data" :autoplay="false" />
    </section>
    <section>
      <MoreProducts category="vetements" title="Notre séléction de vêtements" />
      <MoreProducts category="chaussures" title="Notre séléction de chaussures" />
    </section>
  </div>
</template>



<script setup>
import Carousel from '@/components/CarouselComponent.vue'
import MoreProducts from '@/components/MoreProductsComponent.vue'
import { useProductStore } from '@/stores/product'
import { useCategoryStore } from '@/stores/category'

const productStore = useProductStore()
const categoryStore = useCategoryStore()

productStore.fetchHighlandersProducts()
categoryStore.fetchHighlandersCategories()

</script>

<style scoped></style>
