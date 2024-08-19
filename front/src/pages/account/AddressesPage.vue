<template>
  <div>
    <h2 class="page-title">Mes adresses</h2>
    <Breadcrumb />
    <AccountLayout />
    <Loader v-if="authStore.addresses.loading" />
    <div v-else>
      <div class="address-actions">
        <AddressAddModalButton />
      </div>
      <div v-if="authStore.addresses.data && authStore.addresses.data.length > 0">
        <div class="addresses-grid">
          <Adress v-for="address in authStore.addresses.data" :key="address.address_id" :address="address" />
        </div>
      </div>
      <NoItem v-else />
    </div>
  </div>
</template>

<script setup>
import Loader from '@/components/LoaderComponent.vue'
import NoItem from '@/components/NoItemComponent.vue'
import Breadcrumb from '@/components/BreadcrumbComponent.vue'
import Adress from '@/components/AdressComponent.vue'
import AddressAddModalButton from '@/components/account/AddressAddModalButtonComponent.vue'
import AccountLayout from '@/components/account/AccountLayoutComponent.vue'
import { useAuthStore } from '@/stores/auth'

const authStore = useAuthStore()

authStore.fetchAddresses()

</script>

<style scoped>
.addresses-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
  gap: 20px;
}

.address-actions {
  display: flex;
  justify-content: end;
  align-items: center;
  gap: 0.5rem;
  margin-bottom: 1rem;
}
</style>