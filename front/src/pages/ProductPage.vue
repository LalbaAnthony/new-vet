<template>
  <div>
    <h2 class="page-title">{{ productStore.product.name }}</h2>
    <Loader v-if="productStore.loading || !productStore.product" />
    <div v-else class="product">
      <div class="product-images">
        IMAGE IMAGE IMAGE IMAGE
      </div>
      <div class="product-details">
        <div v-if="productStore.product.categories && productStore.product.categories.length > 0">
          <h3>Catégories: </h3>
          <div class="product-details-categories">
            <Pill v-for="cat in productStore.product.categories" :key="cat.slug" :text="cat.libelle"
              :link="`/categories/${cat.slug}`" type="gradient" />
          </div>
        </div>

        <div v-if="productStore.product.materials && productStore.product.materials.length > 0">
          <h3>Materiaux: </h3>
          <div class="product-details-materials">
            <Pill v-for="mat in productStore.product.materials" :key="mat.slug" :text="mat.libelle" type="light" />
          </div>
        </div>
        <h3>Description: </h3>
        <p class="product-details-description">{{ productStore.product.description }}</p>
      </div>
      <div class="product-actions">

        <div class="product-actions-left">
          <span :class="['price', productStore.product.stock_quantity < 1 ? 'overline' : '']">{{
            productStore.product.price
          }} €</span>
        </div>
        <div class="product-actions-left">
          <Stock :stock="productStore.product.stock_quantity" />
        </div>

        <div class="product-actions-ctas">
          <select v-if="productStore.product.stock_quantity > 0" v-model="qty">
            <option v-for="qty in productStore.product.stock_quantity" :key="qty" :value="qty">{{ qty }}</option>
          </select>
          <button class="button outline" :disabled="productStore.product.stock_quantity < 1"
            @click="authStore.addToCart(productStore.product.slug, qty)">Ajouter au
            panier</button>
          <button class="button" :disabled="productStore.product.stock_quantity < 1"
            @click="authStore.buyNow(productStore.product.slug, qty)">Acheter
            maintenant</button>
        </div>
      </div>
    </div>
    <MoreProducts v-if="productStore.product.categories && productStore.product.categories.length > 0"
      :category="productStore.product.categories[0].slug" />
  </div>
</template>

<script setup>
import { ref } from 'vue'
import Loader from '@/components/LoaderComponent.vue'
import Stock from '@/components/StockComponent.vue'
import Pill from '@/components/PillComponent.vue'
import MoreProducts from '@/components/MoreProductsComponent.vue'
import { useProductStore } from '@/stores/product'
import { useAuthStore } from '@/stores/auth'
import { useRoute } from 'vue-router'

const route = useRoute()
const productStore = useProductStore()
const authStore = useAuthStore()

productStore.fetchProduct(route.params.slug)

const qty = ref(1)

</script>

<style scoped>
/* DESKTOP */
@media (min-width: 1024px) {
  .product {
    display: flex;
    flex-direction: row;
    gap: 2rem;
    justify-content: space-between;
  }
}

/* TABLET */
@media (min-width: 768px) and (max-width: 1023px) {
  .product {
    display: flex;
    flex-direction: row;
    gap: 1rem;
    justify-content: space-between;
  }
}

/* MOBILE */
@media (max-width: 767px) {
  .product {
    display: flex;
    flex-direction: column;
    gap: 2rem;
  }
}

.product-images {
  background-color: red;
  padding: 2rem;
}

.product-details {
  padding: 0 1rem;
}

.product-details-materials,
.product-details-categories {
  display: flex;
  gap: 1rem;
}

.product-details-description {
  color: var(--dark);
  padding: 1rem 0;
  max-width: 450px;
  max-height: 200px;
  overflow: hidden;
}

.product-actions {
  display: flex;
  flex-direction: column;
  gap: 1rem;
  background-color: var(--light);
  padding: 2rem;
  box-shadow: 5px 5px 15px 5px rgba(0, 0, 0, 0.1);
  border-radius: 25px;
}

.product-actions-ctas {
  display: flex;
  flex-direction: column;
  gap: 1rem;
  justify-content: space-between;
}

.product-actions-left {
  margin: 0 0 0 auto;
}

.price {
  color: var(--dark);
  font-size: 2rem;
}
</style>