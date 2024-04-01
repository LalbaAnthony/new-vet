<template>
  <div>
    <h2 class="page-title">Mes moyens de paiement</h2>
    <Breadcrumb />
    <AccountLayout />
    {{ authStore.user }}
    
  </div>
</template>

<script setup>
import Breadcrumb from '@/components/BreadcrumbComponent.vue'
import AccountLayout from '@/components/account/AccountLayoutComponent.vue'
import { useAuthStore } from '@/stores/auth'

const authStore = useAuthStore()

</script>