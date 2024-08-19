<template>
  <div>
    <h2 class="page-title">Détail de ma commande</h2>
    <Breadcrumb />
    <AccountLayout />
    <Loader v-if="authStore.order.loading" />

    <div v-else-if="authStore.order.data" class="order-detail">
      <section class="order-detail__header">
        <h3 class="order-detail__header__title">Commande #{{ authStore.order.data.order_id }}</h3>

        <div class="order-detail__header__left-right">
          <div class="order-detail__header__left">
            <p class="order-detail__header__date">Passée le {{ datetimeToNiceDatetime(authStore.order.data.order_date )}}</p>
          </div>
          <div class="order-detail__header__right">
            <p class="order-detail__header__status">Statut:
              <span class="badge"
                :style="['color: var(--light)]', `background-color: ${authStore.order.data.status.color}`]">
                {{ authStore.order.data.status.libelle }}
              </span>
            </p>
          </div>
        </div>
      </section>

      <section class="order-detail__addresses">
        <h3 class="section-title">Adresses</h3>
        <div class="order-detail__addresses-grid">
          <div class="order-detail__addresses__shipping">
            <h4 class="order-detail__addresses__title">Adresse de livraison</h4>
            <p>{{ niceShippingAddress }}</p>
          </div>
          <div class="order-detail__addresses__billing">
            <h4 class="order-detail__addresses__title">Adresse de facturation</h4>
            <p>{{ niceBillingAddress }}</p>
          </div>
        </div>
      </section>

      <section class="order-detail__products">
        <h3 class="section-title">Produits</h3>
        <div class="order-detail__products__list">
          <div v-for="order_line in authStore.order.data.order_lines" :key="order_line.order_line_id"
            class="order-detail__products__item">
            <!-- <div class="order-detail__products__item__left">
              <img :src="product.image" alt="product.name" class="order-detail__products__item__image" />
            </div> -->
            <div class="order-detail__products__item__right">
              <h5 class="order-detail__products__item__title">{{ order_line.product.name }}</h5>
              <p class="order-detail__products__item__price">{{ order_line.product.price }} €</p>
              <p class="order-detail__products__item__quantity">Quantité: {{ order_line.quantity }}</p>
            </div>
          </div>
        </div>
        <div class="order-detail__total">
          <h4 class="order-detail__total__title">Total</h4>
          <p class="order-detail__total__price">{{ authStore.order.data.total_amount }} €</p>
        </div>
      </section>

    </div>
  </div>
</template>

<script setup>
import { watch, computed } from 'vue'
import Breadcrumb from '@/components/BreadcrumbComponent.vue'
import AccountLayout from '@/components/account/AccountLayoutComponent.vue'
import { useAuthStore } from '@/stores/auth'
import { useRoute } from 'vue-router'
import { datetimeToNiceDatetime } from '@/helpers/helpers.js'

const route = useRoute()

const authStore = useAuthStore()

const niceShippingAddress = computed(() => {
  let address = ''
  if (authStore.order.data.shipping_address) {
    if (authStore.order.data.shipping_address.address1) address += `${authStore.order.data.shipping_address.address1}, `
    if (authStore.order.data.shipping_address.address2) address += `${authStore.order.data.shipping_address.address2}, `
    if (authStore.order.data.shipping_address.zip) address += `${authStore.order.data.shipping_address.zip} `
    if (authStore.order.data.shipping_address.city) address += `${authStore.order.data.shipping_address.city}`
    if (authStore.order.data.shipping_address.country) address += `, ${authStore.order.data.shipping_address.country.name}`
  }
  return address
})

const niceBillingAddress = computed(() => {
  let address = ''
  if (authStore.order.data.billing_address) {
    if (authStore.order.data.billing_address.address1) address += `${authStore.order.data.billing_address.address1}, `
    if (authStore.order.data.billing_address.address2) address += `${authStore.order.data.billing_address.address2}, `
    if (authStore.order.data.billing_address.zip) address += `${authStore.order.data.billing_address.zip} `
    if (authStore.order.data.billing_address.city) address += `${authStore.order.data.billing_address.city}`
    if (authStore.order.data.billing_address.country) address += `, ${authStore.order.data.billing_address.country.name}`
  }
  return address
})

authStore.fetchOrder(route.params.order_id)

watch(
  () => route.params.order_id,
  (order_id) => {
    authStore.fetchOrder(order_id)
  }
)
</script>

<style scoped>
/* DESKTOP */
@media (min-width: 1024px) {
  .order-detail__header__left-right {
    display: flex;
    justify-content: space-between;
  }

  .order-detail__header__right {
    text-align: right;
  }
}

/* TABLET */
@media (min-width: 768px) and (max-width: 1023px) {
  .order-detail__header__left-right {
    display: flex;
    justify-content: space-between;
  }

  .order-detail__header__right {
    text-align: right;
  }
}

/* MOBILE */
@media (max-width: 767px) {
  .order-detail__header__left-right {
    display: flex;
    flex-direction: column;
    gap: 1rem;
  }
}

.order-detail {}

.order-detail__header {}


.order-detail__header__left-right {
  display: flex;
  justify-content: space-between;
}

.order-detail__header__left {}

.order-detail__header__right {}

.order-detail__header__title {
  font-size: 24px;
  margin-bottom: 5px;
}

.order-detail__header__date {
  font-size: 14px;
  color: var(--gray);
}

.order-detail__header__status {
  font-size: 16px;
}

.order-detail__addresses-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
  gap: 20px;
}

.order-detail__addresses__billing,
.order-detail__addresses__shipping {
  margin: 1rem 0;
  padding: 1rem;
  border-radius: 15px;
  background-color: var(--light-gray);
}

.order-detail__addresses__title {
  font-size: 18px;
  font-weight: 700;
  margin-bottom: 5px;
}

.order-detail__products {
  margin-bottom: 20px;
}

.order-detail__products__title {
  font-size: 18px;
  margin-bottom: 10px;
}

.order-detail__products__list {
  display: grid;
  grid-gap: 1rem;
}

.order-detail__products__item {
  display: flex;
  align-items: center;
  border-radius: 15px;
  border: 1px solid gray;
  padding: 10px;
}

.order-detail__products__item__right {
  flex: 1;
  margin-left: 10px;
}

.order-detail__products__item__title {
  font-size: 16px;
  margin-bottom: 5px;
}

.order-detail__products__item__price {
  font-size: 14px;
  color: var(--gray);
}

.order-detail__products__item__quantity {
  font-size: 14px;
  color: var(--gray);
}

.order-detail__total {
  text-align: right;
}

.order-detail__total__title {
  font-size: 18px;
  margin-bottom: 5px;
}

.order-detail__total__price {
  font-size: 24px;
}
</style>