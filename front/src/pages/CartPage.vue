<template>
  <h2 class="page-title">Votre panier</h2>
  {{ authStore.cart }}
</template>

<script setup>
import { useAuthStore } from '@/stores/auth'

const authStore = useAuthStore()

</script>

<style scoped>

</style>

