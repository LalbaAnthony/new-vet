<template>
    <div>
        <h2 class="page-title">Nos produits</h2>
        <SortFilter />
        <div v-if="products && products.length > 0" class="products-grid">
            <Product v-for="product in products" :key="product.slug" :product="product" />
        </div>
        <NoItem what="produit" v-else />
    </div>
</template>

<script setup>
import { ref } from 'vue'
import SortFilter from '@/components/SortFilter.vue'
import Product from '@/components/Product.vue'
import NoItem from '@/components/NoItem.vue'

const products = ref(getProducts())

function getProducts() {
    return [
        {
            image_path: 'https://img.freepik.com/free-photo/smiling-beautiful-young-woman-pink-mini-dress-posing-studio_155003-14602.jpg',
            categories: [
                {
                    slug: 'vetements',
                    libelle: 'Vêtements',
                },
                {
                    slug: 'vetements',
                    libelle: 'Vêtements',
                },
            ],
            name: 'Lorem ipsum dolor sit amet consectetur',
            description: 'Lorem ipsum dolor sit amet consectetur, adipisicing elit.',
            price: '9.99',
            stock: 0,
            slug: 'product1',
        },
    ]
}

</script>

<style scoped>
/* CINEMA SCREEN */
@media (min-width: 1600px) {
    .products-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        grid-gap: 3rem;
    }
}

/* DESKTOP */
@media (min-width: 1024px) and (max-width: 1599px) {
    .products-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        grid-gap: 2rem;
    }
}

/* TABLET */
@media (min-width: 768px) and (max-width: 1023px) {
    .products-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        grid-gap: 1.5rem;
    }
}

/* MOBILE */
@media (max-width: 767px) {
    .products-grid {
        display: row;
        grid-template-rows: repeat(1, 1fr);
        row-gap: 1.5rem;
    }
}

.products-grid {
    margin: 3rem 0;
}
</style>