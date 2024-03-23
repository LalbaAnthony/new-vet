<template>
  <div>
    <h2 class="page-title">{{ productStore.product.data.name }}</h2>
    <Breadcrumb
      :breadcrumb="[
        {
          title: 'Produits',
          path: '/produits',
          active: false
        },
        {
          title: productStore.product.data.name,
          path: `/produit/${productStore.product.data.slug}`,
          active: true
        }
      ]"
    />
    <Loader v-if="productStore.product.loading" />
    <div v-else class="product">
      <div class="product-images">
        <ProductsImages
          :images="productStore.product.data.images"
          :alt="productStore.product.data.name"
        />
      </div>
      <div class="product-details">
        <div
          v-if="
            productStore.product.data.categories && productStore.product.data.categories.length > 0
          "
        >
          <h3>Catégories:</h3>
          <div class="product-details-categories">
            <Pill
              v-for="cat in productStore.product.data.categories"
              :key="cat.slug"
              :text="cat.libelle"
              :link="`/produits?categories=${cat.slug}`"
              type="gradient"
            />
          </div>
        </div>

        <div
          v-if="
            productStore.product.data.materials && productStore.product.data.materials.length > 0
          "
        >
          <h3>Materiaux:</h3>
          <div class="product-details-materials">
            <Pill
              v-for="mat in productStore.product.data.materials"
              :key="mat.slug"
              :text="mat.libelle"
              type="light"
            />
          </div>
        </div>
        <h3>Description:</h3>
        <p class="product-details-description">{{ productStore.product.data.description }}</p>
      </div>
      <div class="product-actions">
        <div class="product-actions-left">
          <span :class="['price', productStore.product.data.stock_quantity < 1 ? 'overline' : '']"
            >{{ productStore.product.data.price }} €</span
          >
        </div>
        <div class="product-actions-left">
          <Stock :stock="productStore.product.data.stock_quantity" />
        </div>

        <div class="product-actions-ctas">
          <select v-if="productStore.product.data.stock_quantity > 0" v-model="qty">
            <option v-for="qty in productStore.product.data.stock_quantity" :key="qty" :value="qty">
              {{ qty }}
            </option>
          </select>
          <button
            class="button outline"
            :disabled="productStore.product.data.stock_quantity < 1"
            @click="authStore.addToCart(productStore.product.data.slug, qty)"
          >
            Ajouter au panier
          </button>
          <button
            class="button"
            :disabled="productStore.product.data.stock_quantity < 1"
            @click="authStore.buyNow(productStore.product.data.slug, qty)"
          >
            Acheter maintenant
          </button>
        </div>
      </div>
    </div>
    <MoreProducts
      v-if="productStore.product.data.categories && productStore.product.data.categories.length > 0"
      :category="productStore.product.data.categories[0].slug"
    />
  </div>
</template>

<script setup>
import { ref, watch } from 'vue'
import Breadcrumb from '@/components/BreadcrumbComponent.vue'
import Loader from '@/components/LoaderComponent.vue'
import Stock from '@/components/StockComponent.vue'
import Pill from '@/components/PillComponent.vue'
import ProductsImages from '@/components/product/ProductsImagesComponent.vue'
import MoreProducts from '@/components/MoreProductsComponent.vue'
import { useProductStore } from '@/stores/product'
import { useAuthStore } from '@/stores/auth'
import { useRoute } from 'vue-router'

const route = useRoute()
const productStore = useProductStore()
const authStore = useAuthStore()

productStore.fetchProduct(route.params.slug)

const qty = ref(1)

watch(
  () => route.params.slug,
  (slug) => {
    productStore.fetchProduct(slug)
  }
)
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

  .product-images {
    margin-bottom: 2rem;
  }
}

.product-images {
  display: flex;
  justify-content: center;
  max-block-size: 300px;
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