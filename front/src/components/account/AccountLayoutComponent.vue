<template>
  <ul class="tabs">
    <li v-for="tab in tabs" :key="tab.name" :class="[tab.name === route.name ? 'active' : '']">
      <router-link :to="tab.path">
        <component :is="tab.icon" class="icon-offset" />
        <span>{{ tab.title }}</span>
      </router-link>
    </li>
  </ul>
</template>

<script setup>
import { ref, shallowRef } from 'vue'
import { useRoute } from 'vue-router'
import IconPerson from '@/icons/IconPerson.vue'
import IconInfo from '@/icons/IconInfo.vue'
import IconKey from '@/icons/IconKey.vue'
import IconBox2 from '@/icons/IconBox2.vue'
import IconCardHeading from '@/icons/IconCardHeading.vue'
import IconCreditCard from '@/icons/IconCreditCard.vue'

const route = useRoute()

const tabs = ref([
  { name: 'account-default', title: 'Mon compte', icon: shallowRef(IconPerson), path: '/mon-compte', active: false },
  { name: 'account-infos', title: 'Mes informations', icon: shallowRef(IconInfo), path: '/mon-compte/infos', active: true },
  { name: 'account-security', title: 'Sécurité', icon: shallowRef(IconKey), path: '/mon-compte/securite', active: false },
  {
    name: 'account-orders-list',
    title: 'Mes commandes',
    icon: shallowRef(IconBox2),
    path: '/mon-compte/mes-commandes',
    active: false
  },
  {
    name: 'account-addresses',
    title: 'Mes adresses',
    icon: shallowRef(IconCardHeading),
    path: '/mon-compte/mes-adresses',
    active: false
  },
  {
    name: 'account-payments',
    title: 'Mes moyens de paiement',
    icon: shallowRef(IconCreditCard),
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