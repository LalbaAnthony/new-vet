<template>
  <ul class="tabs">
    <li v-for="tab in tabs" :key="tab.name">
      <router-link :to="tab.path">{{ tab.title }}</router-link>
    </li>
    <li><span class="txt-danger clickable" @click="authStore.logout()">Se déconnecter</span></li>
  </ul>
</template>

<script setup>
import { useAuthStore } from '@/stores/auth'
import { ref } from 'vue'

const authStore = useAuthStore()

const tabs = ref([
  { name: 'mon-compte', title: 'Mon compte', path: '/mon-compte' },
  { name: 'infos', title: 'Mes informations', path: '/mon-compte/infos' },
  { name: 'securite', title: 'Sécurité', path: '/mon-compte/securite' },
  { name: 'mes-commandes', title: 'Mes commandes', path: '/mon-compte/mes-commandes' },
  { name: 'mes-adresses', title: 'Mes adresses', path: '/mon-compte/mes-adresses' },
  { name: 'mes-moyens-de-paiement', title: 'Mes moyens de paiement', path: '/mon-compte/mes-moyens-de-paiement'},
])
</script>

<style scoped>

.tabs {
  background-color: green;
  max-width: 200px;
}

ul.tabs {
  margin: 1rem 0;
  display: flex;
  flex-direction: column;
  gap: 0.5rem;
}

</style>