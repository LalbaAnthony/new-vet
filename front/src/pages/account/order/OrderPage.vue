<template>
  <div>
    <h2 class="page-title">Détail de ma commande</h2>
    <Breadcrumb />
    {{ route.params.id }}<br>
    {{ authStore.user }}
    <button class="button danger" @click="authStore.logout()">Se déconnecter</button>
  </div>
</template>

<script setup>
import Breadcrumb from '@/components/BreadcrumbComponent.vue'
import { useRoute } from 'vue-router'
import { useAuthStore } from '@/stores/auth'

const route = useRoute()
const authStore = useAuthStore()

</script>