<template>
  <div>
    <h2 class="page-title">Mes informations personnelles</h2>
    <Breadcrumb />
    <AccountLayout />
    
    <div class="main-grid">
      <div class="form-group my-4">
        <label for="first_name">Prénom</label>
        <input type="text" id="first_name" v-model="authStore.user.first_name" disabled />
      </div>

      <div class="form-group my-4">
        <label for="last_name">Nom</label>
        <input type="text" id="last_name" v-model="authStore.user.last_name" disabled />
      </div>

      <div class="form-group my-4">
        <label for="email">E-mail</label>
        <input type="email" id="email" v-model="authStore.user.email" disabled />
      </div>
    </div>
  </div>
</template>

<script setup>
import Breadcrumb from '@/components/BreadcrumbComponent.vue'
import AccountLayout from '@/components/account/AccountLayoutComponent.vue'
import { useAuthStore } from '@/stores/auth'

const authStore = useAuthStore()
</script>

<style scoped>

.main-grid {
  margin: 2rem 0;
  display: grid;
  gap: 1.5rem;
  grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
}
</style>