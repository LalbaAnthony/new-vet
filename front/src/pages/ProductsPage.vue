<template>
    <div>
        <h2 class="page-title">Nos produits</h2>
        <SortFilter />
        <Loader v-if="productStore.products.data.loading" />
        <div v-else>
            <div v-if="productStore.products.data && productStore.products.data.length > 0" class="products-grid">
                <Product v-for="product in productStore.products.data" :key="product.slug" :product="product" />
            </div>
            <NoItem what="produit" v-else />
        </div>
    </div>
</template>

<script setup>
import SortFilter from '@/components/SortFilterComponent.vue'
import Product from '@/components/ProductCardComponent.vue'
import NoItem from '@/components/NoItemComponent.vue'
import Loader from '@/components/LoaderComponent.vue'
import { useProductStore } from '@/stores/product'

const productStore = useProductStore()

productStore.fetchProducts();

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
</style>