<template>
  <section v-if="productStore.moreProducts.data && productStore.moreProducts.data.length > 0" class="more-products">
    <h3 class="section-title">{{ props.title }}</h3>
    <div>
      <div class="products-grid">
        <Product v-for="product in productStore.moreProducts.data" :key="product.slug" :product="product" />
      </div>
    </div>
  </section>
</template>

<script setup>
import Product from '@/components/ProductCardComponent.vue'
import { useProductStore } from '@/stores/product'

const props = defineProps({
  title: {
    type: String,
    default: 'Ces produits pourraient vous intéresser',
    required: false,
  },
  category: {
    type: String,
    required: true,
  },
})

const productStore = useProductStore()

productStore.fetchMoreProducts(props.category)

</script>

<style scoped>
.more-products {
  margin: 3rem 0;
}

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
    display: grid;
    grid-template-columns: 1fr;
    grid-gap: 1.5rem;
  }
}

.products-grid {
  margin: 3rem 0;
}
</style>