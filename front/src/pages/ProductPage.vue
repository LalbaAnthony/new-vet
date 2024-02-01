<template>
  <div>
    <h2 class="page-title">{{ productStore.product.name }}</h2>
    <Loader v-if="productStore.loading || !productStore.product" />
    <div v-else class="product">
      <div class="product-details">Details here</div>
      <div class="product-actions">

        <div class="product-actions-left">
          <span :class="['price', productStore.product.stock_quantity < 1 ? 'overline' : '']">{{
            productStore.product.price
          }} €</span>
          <Stock :stock="productStore.product.stock_quantity" />
        </div>

        <div class="product-actions-ctas">
          <select v-if="productStore.product.stock_quantity > 0">
            <option v-for="qty in productStore.product.stock_quantity" :key="qty" :value="qty">{{ qty }}</option>
          </select>
          <button :class="['button', productStore.product.stock_quantity < 1 ? 'disabled' : '']">Ajouter au
            panier</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import Loader from '@/components/LoaderComponent.vue'
import Stock from '@/components/StockComponent.vue'
import { useProductStore } from '@/stores/product'
import { useRoute } from 'vue-router'

const route = useRoute()
const productStore = useProductStore()

productStore.fetchProduct(route.params.slug)

</script>

<style scoped>
/* DESKTOP */
@media (min-width: 1024px) {
  .product {
    display: flex;
    flex-direction: row;
    justify-content: space-between;
  }

  .product-actions-ctas {
    display: flex;
    flex-direction: column;
    gap: 1rem;
  }
}

/* TABLET */
@media (min-width: 768px) and (max-width: 1023px) {
  .product {
    display: flex;
    flex-direction: row;
    justify-content: space-between;
  }

  .product-actions-ctas {
    display: flex;
    flex-direction: column;
    gap: 1rem;
  }
}

/* MOBILE */
@media (max-width: 767px) {
  .product {
    display: flex;
    flex-direction: column;
    gap: 2rem;
  }

  .product-actions-ctas {
    display: flex;
    flex-direction: row;
    gap: 1rem;
    justify-content: space-between;
  }
}






.product-details {
  background-color: green;
  padding: 2rem;
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

.product-actions-left {
  margin: 0 0 0 auto;
}

.price {
  font-size: 2rem;
}
</style>