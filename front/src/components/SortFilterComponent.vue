<template>
  <div class="sort-filters-bloc">
    <!-- Filtres -->
    <Menu as="div" v-slot="{ open }" class="filters">
      <MenuButton class="filters-button">
        Filtrer
        <IconChevronDown :class="['chevron', open ? 'open' : '']" />
      </MenuButton>
      <MenuItems class="filters-list">
        <MenuItems>el</MenuItems>
        <MenuItems>el</MenuItems>
        <MenuItems>el</MenuItems>
        <MenuItems>el</MenuItems>
        <MenuItems>el</MenuItems>
        <MenuItems>el</MenuItems>
        <MenuItems>el</MenuItems>
      </MenuItems>
    </Menu>
    <!-- Trie -->
    <select @change="setSort($event.target.value)">
      <option value="default">Trier par</option>
      <option value="price-asc">Les moins chers</option>
      <option value="price-desc">Les plus chers</option>
      <option value="created_at-desc">Les plus récents</option>
      <option value="created_at-asc">Les plus anciens</option>
      <option value="name-asc">De A à Z</option>
      <option value="name-desc">De Z à A</option>
    </select>
  </div>
</template>

<script setup>
import IconChevronDown from '@/components/icons/IconChevronDown.vue'
import { Menu, MenuButton, MenuItems, MenuItem } from '@headlessui/vue'
import { useRoute, useRouter } from 'vue-router'

const route = useRoute()
const router = useRouter()

function setSort(value) {
  const query = { ...route.query }
  if (value === 'default') {
    delete query.sort
  } else {
    query.sort = value
  }
  router.push({ query })
}

</script>

<style scoped>
.sort-filters-bloc {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin: 2rem 0;
}

.filters {
  position: relative;
}

.filters-button {
  padding: 0.5rem 1rem;
  background-color: var(--light);
  border: 2px solid #ccc;
  color: var(--dark);
  border-radius: 25px;
  cursor: pointer;
  display: flex;
  align-items: center;
  font-family: "Ubuntu", "Roboto", sans-serif;
}

.filters-button .chevron {
  width: 1rem;
  height: 1rem;
  margin-left: 0.5rem;
  transition: transform 0.2s ease-in-out;
}

.filters-button .chevron.open {
  transform: rotate(180deg);
}

.filters-list {
  position: absolute;
  top: 100%;
  left: 0;
  z-index: 10;
  background-color: var(--light);
  border: 1px solid var(--primary);
  border-radius: 0.5rem;
  padding: 0.5rem;
  display: flex;
  flex-direction: column;
  gap: 0.5rem;
}
</style>