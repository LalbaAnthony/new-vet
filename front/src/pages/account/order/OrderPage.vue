<template>
  <div>
    <h2 class="page-title">Détail de ma commande</h2>
    <Breadcrumb />
    <AccountLayout />
    {{ route.params.id }}<br>
    {{ authStore.user }}
    
  </div>
</template>

<script setup>
import Breadcrumb from '@/components/BreadcrumbComponent.vue'
import AccountLayout from '@/components/account/AccountLayoutComponent.vue'
import { useRoute } from 'vue-router'
import { useAuthStore } from '@/stores/auth'

const route = useRoute()
const authStore = useAuthStore()

</script>