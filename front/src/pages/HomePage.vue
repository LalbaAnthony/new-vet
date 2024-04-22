<template>
  <div>
    <section class="hero">
      <div class="hero-content">
        <h1>NEW VET</h1>
        <p>Le site de vente en ligne de mode</p>
        <button class="button outline">Découvrir</button>
      </div>
      <div class="hero-images">
        <img src="/images/hero-image.webp" alt="Aucun image de disponible" />
        <div class="fade"></div>
      </div>

    </section>
    <section>
      <Carousel type="category" :items="categoriesCarousel" :autoplay="true" />
    </section>
    <section>
      <Carousel type="product" title="Les Highlanders du moment" :items="productsCarousel" :autoplay="true" />
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
section.hero {
  /* background-color: red; */
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 2rem;
}

.hero-content {
  max-width: 50%;
}

section.hero h1 {
  font-size: 2.5rem;
  margin-bottom: 1rem;
}

section.hero p {
  font-size: 1.5rem;
  margin-bottom: 2rem;
}

.hero-images {
  position: relative;
  width: 50%;
  /* height: 100%; */
}

.hero-images img {
  display: block;
  position: relative;
  z-index: 1;
  width: 100%;
}

.hero-images .fade {
  position: absolute;
  bottom: 0;
  width: 100%;
  height: 100px;
  z-index: 2;
  background: linear-gradient(to bottom, rgba(255, 255, 255, 0) 33%, rgba(255, 255, 255, 1) 100%) repeat scroll 0 0;
}
</style>
