<template>
  <div>
    <section class="hero">
      <div class="hero-content">
        <h1 class="hero-title">{{ SITE_NAME }}</h1>
        <p>Le site de vente en ligne de vêtement pour femme.</p>
        <router-link to="/produits" class="button outline">Découvrir</router-link>
      </div>
      <div class="hero-images">
        <img src="/images/hero/hero-image-medium.webp" :alt="`Image de banière de ${SITE_NAME}`" />
        <div class="fade"></div>
      </div>
      <div class="hero-graph-contener">
        <img class="hero-graph" src="/images/hero/hero-graph.webp" />
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
import { SITE_NAME } from '@/config';
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
/* DESKTOP */
@media (min-width: 1024px) {
  section.hero {
    flex-direction: row;
    padding: 4rem;
  }
}

/* TABLET */
@media (min-width: 768px) and (max-width: 1023px) {
  section.hero {
    flex-direction: row;
    padding: 3rem;
  }
}

/* MOBILE */
@media (max-width: 767px) {
  section.hero {
    flex-direction: column;
    flex-direction: column-reverse;
    gap: 2rem;
  }
}

section.hero {
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.hero-title:after {
  content: "";
  display: block;
  width: 170px;
  height: 7px;
  border-radius: 25px;
  background: var(--secondary);
  background: linear-gradient(90deg, var(--secondary) 0%, var(--primary) 100%);
  margin-top: 0.25rem;
  animation-name: grownFromLeft;
  animation-duration: 0.5s;
}

.hero-content {
  text-align: left;
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
  width: 75%;
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

.hero-graph-contener {
  position: relative;
  width: 0;
  height: 0;
}

/* DESKTOP */
@media (min-width: 1024px) {
  .hero-graph {
    left: -260px;
    top: -200px;
    width: 300px;
  }
}

/* TABLET */
@media (min-width: 768px) and (max-width: 1023px) {
  .hero-graph {
    left: -175px;
    top: -150px;
    width: 250px;
  }
}

/* MOBILE */
@media (max-width: 767px) {
  .hero-graph {
    left: -100px;
    top: -30px;
    width: 200px;
  }
}

.hero-graph {
  position: absolute;
  z-index: -5;
}
</style>
