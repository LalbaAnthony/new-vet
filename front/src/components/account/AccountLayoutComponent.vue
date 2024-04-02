<template>
  <ul class="tabs">
    <li v-for="tab in tabs" :key="tab.name" :class="[tab.name === route.name ? 'active' : '']">
      <router-link :to="tab.path">{{ tab.title }}</router-link>
    </li>
  </ul>
</template>

<script setup>
import { ref } from 'vue'
import { useRoute } from 'vue-router'

const route = useRoute()

const tabs = ref([
  { name: 'account-default', title: 'Mon compte', path: '/mon-compte', active: false },
  { name: 'account-infos', title: 'Mes informations', path: '/mon-compte/infos', active: true },
  { name: 'account-security', title: 'Sécurité', path: '/mon-compte/securite', active: false },
  {
    name: 'account-orders-list',
    title: 'Mes commandes',
    path: '/mon-compte/mes-commandes',
    active: false
  },
  {
    name: 'account-addresses',
    title: 'Mes adresses',
    path: '/mon-compte/mes-adresses',
    active: false
  },
  {
    name: 'account-payments',
    title: 'Mes moyens de paiement',
    path: '/mon-compte/mes-moyens-de-paiement',
    active: false
  }
])
</script>

<style scoped>
ul.tabs {
  margin: 1rem 0;
  display: flex;
  flex-direction: row;
  gap: 0.5rem;
  flex-wrap: wrap;
}

ul.tabs li {
  background-color: var(--light-gray);
  padding: 0.25rem 1rem;
  border-radius: 10px;
  border: none;
  font-size: 1rem;
  font-weight: 500;
  cursor: pointer;
  font-family: 'Ubuntu', 'Roboto', sans-serif;
  transition: all 0.3s;
}

ul.tabs li:hover {
  padding: 0.25rem 1.5rem;

}

ul.tabs li.active {
  background-color: var(--secondary);
}

ul.tabs li * {
  color: var(--dark);
}
ul.tabs li.active * {
  color: var(--light);
}
</style>