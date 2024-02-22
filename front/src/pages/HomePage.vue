<template>
  <div>
    <section>
      <Carousel title="Le meilleur de nos produits" :items="productsCarousel" :autoplay="true" />
    </section>
    <section>
      <Carousel title="Nos catégories préférées" :items="categoriesCarousel" :autoplay="true" />
    </section>
    <section>
      <MoreProducts category="vetements" title="Notre séléction de vêtements" />
      <MoreProducts category="chaussures" title="Notre séléction de chaussures" />
    </section>
  </div>
</template>



<script setup>
import { onMounted, ref } from 'vue'
import Carousel from '@/components/CarouselComponent.vue'
import MoreProducts from '@/components/MoreProductsComponent.vue'
import { useProductStore } from '@/stores/product'
import { useCategoryStore } from '@/stores/category'

const productStore = useProductStore()
const categoryStore = useCategoryStore()

const productsCarousel = ref([])
const categoriesCarousel = ref([])

onMounted(() => {
  // Load & compute categories to be displayed in carousel
  categoryStore.fetchHighlandersCategories().then(() => {
    categoriesCarousel.value = categoryStore.highlandersCategories.data.map(item => ({
      slug: item.slug,
      libelle: item.libelle,
      link: `/categorie/${item.slug}`,
      path: item.path
    }))
  })
  // Load & compute products to be displayed in carousel
  productStore.fetchHighlandersProducts().then(() => {
    productsCarousel.value = productStore.highlandersProducts.data.map(item => ({
      slug: item.slug,
      name: item.name,
      link: `/produits/${item.slug}`,
      path: item.path
    }))
  })
})


</script>

<style scoped></style>
