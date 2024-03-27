<template>
  <div>
    <h2 class="page-title">Rechercher un produit, une catégorie, ...</h2>
    <Breadcrumb />
    <Loader v-if="productStore.products.loading && categoryStore.categories.loading" />
    <div v-else>
      <div v-if="(productStore.products.data && productStore.products.data.length > 0) || (categoryStore.categories.data && categoryStore.categories.data.length > 0)">
        <section v-if="productStore.products.data && productStore.products.data.length > 0">
          <h3 class="section-title">Produits</h3>
          <div class="products-grid">
            <Product v-for="product in productStore.products.data" :key="product.slug" :product="product" />
          </div>
        </section>
        <section v-if="categoryStore.categories.data && categoryStore.categories.data.length > 0">
          <h3 class="section-title">Catégories</h3>
          <div class="categories-grid">
            <Category v-for="category in categoryStore.categories.data" :key="category.slug" :category="category" />
          </div>
        </section>
      </div>
      <NoItem v-else />
    </div>
  </div>
</template>

<script setup>
import Breadcrumb from '@/components/BreadcrumbComponent.vue'
import Product from '@/components/product/ProductItemComponent.vue'
import Category from '@/components/category/CategoryItemComponent.vue'
import NoItem from '@/components/NoItemComponent.vue'
import Loader from '@/components/LoaderComponent.vue'
import { useProductStore } from '@/stores/product'
import { useCategoryStore } from '@/stores/category'
import { useRoute } from 'vue-router'
import { watch } from 'vue'

const route = useRoute()

const productStore = useProductStore()
const categoryStore = useCategoryStore()

async function loadElements() {
  await productStore.fetchProducts({
    search: route.query.search,
    per_page: 6,
  })
  await categoryStore.fetchCategories({
    search: route.query.search,
    per_page: 6,
  })
}

// Fetch products on component mount
loadElements()

// Watch route changes
watch(() => route.query, loadElements)

</script>

<style scoped>
/* CINEMA SCREEN */
@media (min-width: 1600px) {
  .products-grid {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      grid-gap: 4rem;
  }
}

/* DESKTOP */
@media (min-width: 1024px) and (max-width: 1599px) {
  .products-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      grid-gap: 3rem;
  }
}

/* TABLET */
@media (min-width: 768px) and (max-width: 1023px) {
  .products-grid {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      grid-gap: 2rem;
  }
}

/* MOBILE */
@media (max-width: 767px) {
  .products-grid {
      display: row;
      grid-template-rows: repeat(1, 1fr);
      row-gap: 2rem;
  }
}

.products-grid {
  margin: 3rem 0;
}

/* CINEMA SCREEN */
@media (min-width: 1600px) {
  .categories-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    grid-gap: 4rem;
  }
}

/* DESKTOP */
@media (min-width: 1024px) and (max-width: 1599px) {
  .categories-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    grid-gap: 3rem;
  }
}

/* TABLET */
@media (min-width: 768px) and (max-width: 1023px) {
  .categories-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    grid-gap: 2rem;
  }
}

/* MOBILE */
@media (max-width: 767px) {
  .categories-grid {
    display: grid;
    grid-template-columns: 1fr;
    grid-gap: 1.5rem;
  }
}

.categories-grid {
  margin: 3rem 0;
  min-height: 50vh;
}

</style>
