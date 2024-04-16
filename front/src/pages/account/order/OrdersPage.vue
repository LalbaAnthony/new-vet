<template>
  <div>
    <h2 class="page-title">Liste de mes commandes</h2>
    <Breadcrumb />
    <AccountLayout />
    <SortFilter />
    <Loader v-if="authStore.orders.loading" />
    <div v-else>
      <div v-if="authStore.orders.data && authStore.orders.data.length > 0">
        <div class="orders-grid">
          <OrderItem v-for="order in authStore.orders.data" :key="order.id" :order="order" />
        </div>
        <Pagination :total="authStore.orders.pagination.total" :page="authStore.orders.pagination.page"
          :perPage="authStore.orders.pagination.per_page"
                @update-page="(page) => authStore.ordersChangePage(page)" />
      </div>
      <NoItem v-else />
    </div>
  </div>
</template>

<script setup>
import Breadcrumb from '@/components/BreadcrumbComponent.vue'
import OrderItem from '@/components/account/order/OrderItemComponent.vue'
import SortFilter from '@/components/account/order/SortFilterComponent.vue'
import NoItem from '@/components/NoItemComponent.vue'
import Loader from '@/components/LoaderComponent.vue'
import AccountLayout from '@/components/account/AccountLayoutComponent.vue'
import Pagination from '@/components/PaginationComponent.vue'
import { useAuthStore } from '@/stores/auth'
import { useRoute } from 'vue-router'
import { computed, watch } from 'vue'

const authStore = useAuthStore()
const route = useRoute()

const firstJanuaryOfLowerYear = computed(() => {
  return route.query.years ? `${route.query.years?.split(',').reduce((a, b) => Math.min(a, b))}-01-01` : null
})

const lastDecemberOfHigherYear = computed(() => {
  return route.query.years ? `${route.query.years?.split(',').reduce((a, b) => Math.max(a, b))}-12-31` : null
})

async function loadOrders() {
  authStore.fetchOrders({
    date_start: firstJanuaryOfLowerYear.value,
    date_end: lastDecemberOfHigherYear.value,
    sort: route.query.sort ? [{
      order_by: route.query.sort?.split('-')[0] || null,
      order: route.query.sort?.split('-')[1] || null
    }] : [
      { order: 'DESC', order_by: 'order_date' }
    ]
  })
}

// Fetch products on component mount
loadOrders()

// Watch route changes
watch(() => route.query, loadOrders)

</script>

<style scoped>

.orders-grid {
  display: grid;
  grid-template-columns: 1fr;
  gap: 1rem;
}

</style>