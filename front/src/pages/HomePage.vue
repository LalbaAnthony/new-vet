<template>
  <div>
    <section>
      <Carousel type="category" :items="categoriesCarousel" :autoplay="true" class="half-space"/>
    </section>
    <section>
      <Carousel type="product" title="Les Highlanders du moment" :items="productsCarousel" :autoplay="true" class="half-space"/>
    </section>
  </div>
</template>

<script setup>
import { onMounted, ref } from 'vue'
import Carousel from '@/components/CarouselComponent.vue'
import { useCategoryStore } from '@/stores/category'
import { useProductStore } from '@/stores/product'

const categoryStore = useCategoryStore()
const productStore = useProductStore()

const categoriesCarousel = ref([])
const productsCarousel = ref([])

onMounted(() => {
  // Load & compute categories to be displayed in carousel
  categoryStore.fetchHighlandersCategories().then(() => {
    categoriesCarousel.value = categoryStore.highlandersCategories.data
  })
  // Load & compute products to be displayed in carousel
  productStore.fetchHighlandersProducts().then(() => {
    productsCarousel.value = productStore.highlandersProducts.data
  })
})

</script>

<style scoped>

.half-space {
  margin-bottom: 2rem;
  max-width: 1200px;
}

</style>
