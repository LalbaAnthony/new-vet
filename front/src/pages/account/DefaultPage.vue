<template>
  <div>
    <h2 class="page-title">Mon compte</h2>
    <Breadcrumb />
    <AccountLayout />
    {{ authStore.user }}
    <button @click="authStore.logout()" class="button danger">Se déconnecter</button>
  </div>
</template>

<script setup>
import Breadcrumb from '@/components/BreadcrumbComponent.vue'
import AccountLayout from '@/components/account/AccountLayoutComponent.vue'
import { useAuthStore } from '@/stores/auth'

const authStore = useAuthStore()
</script>