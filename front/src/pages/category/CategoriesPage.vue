<template>
  <div>
    <h2 class="page-title">Nos catégories</h2>
    <Breadcrumb />
    <Loader v-if="categoryStore.categories.loading" />
    <div v-else>
      <div v-if="categoryStore.categories.data && categoryStore.categories.data.length > 0">
        <div class="categories-grid">
          <Category v-for="category in categoryStore.categories.data" :key="category.slug" :category="category" />
        </div>
      </div>
      <NoItem :cta="{ text: 'Retour', to: '/categories' }" v-else />
      <Pagination :total="categoryStore.categories.pagination.total" :page="categoryStore.categories.pagination.page"
      :perPage="categoryStore.categories.pagination.per_page"
      @update-page="(page) => categoryStore.changePage(page)" />
    </div>
  </div>
</template>

<script setup>
import Breadcrumb from '@/components/BreadcrumbComponent.vue'
import Pagination from '@/components/PaginationComponent.vue'
import Category from '@/components/category/CategoryItemComponent.vue'
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