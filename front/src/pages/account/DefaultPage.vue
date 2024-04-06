<template>
  <div>
    <h2 class="page-title">Mon compte</h2>
    <Breadcrumb />
    <AccountLayout />

    <div class="main-content">
      <IconPersonCircle class="main-icon" />
      <span class="name">{{ authStore.user?.first_name }} {{ authStore.user?.last_name }}</span>
      <!-- <button @click="authStore.logout()" class="button danger">Se déconnecter</button> -->
    </div>
  </div>
</template>

<script setup>
import Breadcrumb from '@/components/BreadcrumbComponent.vue'
import AccountLayout from '@/components/account/AccountLayoutComponent.vue'
import IconPersonCircle from '@/icons/IconPersonCircle.vue'
import { useAuthStore } from '@/stores/auth'

const authStore = useAuthStore()
</script>

<style scoped>
.main-content {
  display: grid;
  gap: 1rem;
  justify-items: center;
  margin-top: 5rem;
  margin-bottom: 2rem;
}

.main-icon {
  color: var(--gray);
  width: 5rem;
  height: 5rem;
}

.name {
  color: var(--dark);
  font-size: 1.5rem;
  font-weight: 500;
  font: 'Ubuntu', 'Roboto', sans-serif;
}

.clickables {
  gap: 1rem;
}
</style>