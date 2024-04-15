<template>
  <div class="sort-filters-bloc">
    <!-- Filtres -->
    <Menu as="div" v-slot="{ open }" class="dropdown">
      <MenuButton class="dropdown-button">
        <span> Filtrer </span>
        <IconChevronDown :class="['chevron', open ? 'open' : '']" />
      </MenuButton>
      <MenuItems class="dropdown-list">
        <div @click="resetFilter()" class="dropdown-list-reset">
          <IconArrowRepeat />Toutes les commandes
        </div>
        <hr />
        <ul>
          <li v-for="status in statusStore.statuses.data" :key="status.status_id" @click="toggleStatus(status.status_id)">
            <input type="checkbox" :id="status.status_id" :value="status.status_id"
              :checked="route.query.categories?.split(',').includes(status.status_id)" />
            {{ status.libelle }}
          </li>
        </ul>
        <hr />
        <ul>
          <li v-for="year in getAllYearsFromDateToNow(authStore.user.created_at, true)" :key="year" @click="toggleYear(year)">
            <input type="checkbox" :id="year" :value="year" :checked="route.query.year?.split(',').includes(year)" />
            {{ year }}
          </li>
        </ul>
      </MenuItems>
    </Menu>
    <!-- Trie -->
    <Menu as="div" v-slot="{ open }" class="dropdown">
      <MenuButton class="dropdown-button">
        <span> Trier par </span>
        <IconChevronDown :class="['chevron', open ? 'open' : '']" />
      </MenuButton>
      <MenuItems class="dropdown-list">
        <div @click="resetSort()" class="dropdown-list-reset">
          <IconArrowRepeat />Par défaut
        </div>
        <hr />
        <ul>
          <li :class="[route.query.sort === 'created_at-desc' ? 'selected' : '']" @click="toggleSort('created_at-desc')">
            Plus récentes
          </li>
          <li :class="[route.query.sort === 'created_at-asc' ? 'selected' : '']" @click="toggleSort('created_at-asc')">
            Plus anciennes
          </li>
        </ul>
      </MenuItems>
    </Menu>
  </div>
</template>

<script setup>
import IconArrowRepeat from '@/icons/IconArrowRepeat.vue'
import IconChevronDown from '@/icons/IconChevronDown.vue'
import { Menu, MenuButton, MenuItems } from '@headlessui/vue'
import { useRoute, useRouter } from 'vue-router'
import { useStatusStore } from '@/stores/status'
import { useAuthStore } from '@/stores/auth'
import { getAllYearsFromDateToNow } from '@/helpers/helpers.js'

const route = useRoute()
const router = useRouter()

const authStore = useAuthStore()
const statusStore = useStatusStore()

statusStore.fetchStatuses()

function resetFilter() {
  const query = { ...route.query }
  delete query.years
  delete query.statuses
  router.push({ path: route.path, query })
}

function resetSort() {
  const query = { ...route.query }
  delete query.sort
  router.push({ path: route.path, query })
}

function toggleSort(value) {
  const query = { ...route.query }
  if (value === 'default') {
    delete query.sort
  } else {
    query.sort = value
  }
  router.push({ path: route.path, query })
}

function toggleStatus(status) {
  status = status.toString()
  const query = { ...route.query }
  if (query.statuses) {
    const statuses = query.statuses.split(',')
    if (statuses.includes(status)) {
      query.statuses = statuses.filter((s) => s !== status).join(',')
    } else {
      query.statuses = statuses.concat(status).join(',')
    }
  } else {
    query.statuses = status
  }
  router.push({ path: route.path, query })
}

function toggleYear(year) {
  year = year.toString()
  const query = { ...route.query }
  if (query.years) {
    const years = query.years.split(',')
    if (years.includes(year)) {
      query.years = years.filter((y) => y !== year).join(',')
    } else {
      query.years = years.concat(year).join(',')
    }
  } else {
    query.years = year
  }
  router.push({ path: route.path, query })
}

</script>

<style scoped>
.sort-filters-bloc {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin: 1rem 0;
}

.dropdown {
  position: relative;
}

.dropdown-button {
  padding: 0.5rem 1rem;
  background-color: var(--light);
  border: 2px solid #ccc;
  color: var(--dark);
  border-radius: 25px;
  cursor: pointer;
  display: flex;
  align-items: center;
  font-family: 'Ubuntu', 'Roboto', sans-serif;
}

.dropdown-button .chevron {
  width: 1rem;
  height: 1rem;
  margin-left: 0.5rem;
  transition: transform 0.2s ease-in-out;
}

.dropdown-button .chevron.open {
  transform: rotate(180deg);
  color: var(--secondary);
}

.dropdown-list {
  position: absolute;
  top: 110%;
  left: 0;
  z-index: 10;
  background-color: var(--light);
  border: none;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  border-radius: 0.5rem;
  padding: 0.5rem;
  display: flex;
  flex-direction: column;
  gap: 0.5rem;
}

.dropdown-list-reset {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  margin: 0 auto;
  cursor: pointer;
  color: var(--dark);
}

.dropdown-list ul>* {
  padding: 0.0125rem 1rem;
  min-width: 150px;
  cursor: pointer;
  display: flex;
  align-items: center;
  gap: 0.5rem;
}

.dropdown-list input[type='checkbox'] {
  accent-color: var(--primary);
}

.dropdown-list .selected {
  font-weight: bold;
  color: var(--primary);
}
</style>