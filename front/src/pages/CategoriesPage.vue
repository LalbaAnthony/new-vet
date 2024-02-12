<template>
  <div>
    <h2 class="page-title">Nos catégories</h2>
    <Loader v-if="categoryStore.categories.loading" />
    <div v-else>
      <div v-if="categoryStore.categories.data && categoryStore.categories.data.length > 0" class="categories-grid">
        <CategoryItem v-for="category in categoryStore.categories.data" :key="category.slug" :category="category" />
      </div>
      <NoItem what="produit" v-else />
    </div>
  </div>
</template>

<script setup>
import CategoryItem from '@/components/CategoryItemComponent.vue'
import NoItem from '@/components/NoItemComponent.vue'
import Loader from '@/components/LoaderComponent.vue'
import { useCategoryStore } from '@/stores/category'

const categoryStore = useCategoryStore()

categoryStore.fetchCategories();

</script>

<style scoped>
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