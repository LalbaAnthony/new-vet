<template>
    <div>
        <h2 class="page-title">Nos produits</h2>
        <Breadcrumb />
        <SortFilter />
        <Loader v-if="productStore.products.loading" />
        <div v-else>
            <div v-if="productStore.products.data && productStore.products.data.length > 0">
                <div class="products-grid">
                    <Product v-for="product in productStore.products.data" :key="product.slug" :product="product" />
                </div>
                <Pagination :total="productStore.products.pagination.total" :page="productStore.products.pagination.page"
                :perPage="productStore.products.pagination.per_page"
                @update-page="(page) => productStore.changePage(page)" />
            </div>
            <NoItem what="produit" :cta="{ text: 'Retour', to: '/produits' }" v-else />
        </div>
    </div>
</template>

<script setup>
import Breadcrumb from '@/components/BreadcrumbComponent.vue'
import SortFilter from '@/components/SortFilterComponent.vue'
import Pagination from '@/components/PaginationComponent.vue'
import Product from '@/components/product/ProductItemComponent.vue'
import NoItem from '@/components/NoItemComponent.vue'
import Loader from '@/components/LoaderComponent.vue'
import { useProductStore } from '@/stores/product'
import { useRoute } from 'vue-router'
import { watch } from 'vue'

const route = useRoute()
const productStore = useProductStore()

async function loadProducts() {
    await productStore.fetchProducts({
        materials: [route.query.materials || null],
        categories: [route.query.categories || null],
        sort: route.query.sort ? [{
            order_by: route.query.sort?.split('-')[0] || null,
            order: route.query.sort?.split('-')[1] || null
        }] : [
            { order: 'ASC', order_by: 'sort_order' },
            { order: 'DESC', order_by: 'stock_quantity' }
        ]
    })
}

// Fetch products on component mount
loadProducts()

// Watch route changes
watch(() => route.query, loadProducts)

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