<template>
  <header>
    <router-link to="/">
      <h1 class="site-title">NEW VET</h1>
    </router-link>

    <!-- <div lass="menu-list">
      <router-link v-for=" item in menu " :key="item.slug" :to="item.path"
        :class="route.name === item.slug ? 'selected' : ''">
        <component class="icon-offset" :is="getComponent(item.icon)" />
        {{ item.name }}
      </router-link>
    </div> -->
  </header>
</template>

<script setup>
import { ref } from 'vue'
import { useRoute } from 'vue-router'
import IconHouse from '@/components/icons/IconHouse.vue'
import IconCalendar from '@/components/icons/IconCalendar.vue'
import IconBuilding from '@/components/icons/IconBuilding.vue'
import IconPeople from '@/components/icons/IconPeople.vue'
import IconEnvelope from '@/components/icons/IconEnvelope.vue'

const route = useRoute()
const menu = ref([
  {
    name: 'Contact',
    slug: 'contact',
    path: '/contact',
    icon: 'IconEnvelope',
  },
])

const getComponent = (icon) => {
  switch (icon) {
    case 'IconHouse':
      return IconHouse;
    case 'IconCalendar':
      return IconCalendar;
    case 'IconBuilding':
      return IconBuilding;
    case 'IconPeople':
      return IconPeople;
    case 'IconEnvelope':
      return IconEnvelope;
    default:
      return null;
  }
};

</script>

<style scoped>
header {
  background: var(--secondary);
  background: linear-gradient(90deg, var(--secondary) 0%, var(--primary) 100%);
  color: var(--light);
  display: flex;
  flex-direction: column;
}

h1.site-title {
  color: var(--light);
  font-size: 2rem;
  margin: 0;
  padding: 1rem;
  text-align: center;
  animation-name: fromBottom;
  animation-duration: 0.5s;
}

@keyframes fromBottom {
  from {
    opacity: 0;
    transform: translateY(15px);
  }

  to {
    opacity: 1;
    transform: translateY(0);
  }
}


.menu-list {
  display: flex;
  flex-direction: row;
  justify-content: space-around;
  align-items: center;
  padding: 1rem;
}
</style>
