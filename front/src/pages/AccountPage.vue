<template>
  <div>
    <h2 class="page-title">Mon compte</h2>
    <Breadcrumb />
    <button class="button danger" @click="authStore.logout()">Se déconnecter</button>
  </div>
</template>

<script setup>
import Breadcrumb from '@/components/BreadcrumbComponent.vue'
import { useAuthStore } from '@/stores/auth'

const authStore = useAuthStore()
</script>