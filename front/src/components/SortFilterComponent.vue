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
          <IconArrowRepeat />Tous les produits
        </div>
        <hr>
        <ul>
          <li v-for="category in categoryStore.categories.data" :key="category.slug"
            @click="toggleCategory(category.slug)">
            <input type="checkbox" :id="category.slug" :value="category.slug"
              :checked="route.query.categories?.split(',').includes(category.slug)">
            {{ category.libelle }}
          </li>
        </ul>
        <hr>
        <ul>
          <li v-for="material in materialStore.materials.data" :key="material.slug"
            @click="toggleMaterial(material.slug)">
            <input type="checkbox" :id="material.slug" :value="material.slug"
              :checked="route.query.materials?.split(',').includes(material.slug)">
            {{ material.libelle }}
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
        <hr>
        <ul>
          <li :class="[route.query.sort === 'price-asc' ? 'selected' : '']" @click="toggleSort('price-asc')">Prix
            croissant</li>
          <li :class="[route.query.sort === 'price-desc' ? 'selected' : '']" @click="toggleSort('price-desc')">Prix
            décroissant</li>
          <li :class="[route.query.sort === 'created_at-desc' ? 'selected' : '']" @click="toggleSort('created_at-desc')">
            Plus récents</li>
          <li :class="[route.query.sort === 'created_at-asc' ? 'selected' : '']" @click="toggleSort('created_at-asc')">
            Plus anciens</li>
          <li :class="[route.query.sort === 'name-asc' ? 'selected' : '']" @click="toggleSort('name-asc')">A à Z</li>
          <li :class="[route.query.sort === 'name-desc' ? 'selected' : '']" @click="toggleSort('name-desc')">Z à A</li>
        </ul>
      </MenuItems>
    </Menu>
  </div>
</template>

<script setup>
import IconArrowRepeat from '@/components/icons/IconArrowRepeat.vue'
import IconChevronDown from '@/components/icons/IconChevronDown.vue'
import { Menu, MenuButton, MenuItems, MenuItem } from '@headlessui/vue'
import { defineEmits } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { useCategoryStore } from '@/stores/category'
import { useMaterialStore } from '@/stores/material'

const route = useRoute()
const router = useRouter()
const categoryStore = useCategoryStore()
const materialStore = useMaterialStore()

categoryStore.fetchCategories();
materialStore.fetchMaterials();

const emit = defineEmits(['updateQuery'])

function resetFilter() {
  const query = { ...route.query }
  delete query.categories
  delete query.materials
  router.push({ query })
  emit('updateQuery', true)
}

function resetSort() {
  const query = { ...route.query }
  delete query.sort
  router.push({ query })
  emit('updateQuery', true)
}

function toggleSort(value) {
  const query = { ...route.query }
  if (value === 'default') {
    delete query.sort
  } else {
    query.sort = value
  }
  router.push({ query })
  emit('updateQuery', true)
}

function toggleCategory(category) {
  const query = { ...route.query }
  if (query.categories) {
    const categories = query.categories.split(',')
    if (categories.includes(category)) {
      query.categories = categories.filter((c) => c !== category).join(',')
    } else {
      query.categories = categories.concat(category).join(',')
    }
  } else {
    query.categories = category
  }
  router.push({ query })
  emit('updateQuery', true)
}

function toggleMaterial(material) {
  const query = { ...route.query }
  if (query.materials) {
    const materials = query.materials.split(',')
    if (materials.includes(material)) {
      query.materials = materials.filter((m) => m !== material).join(',')
    } else {
      query.materials = materials.concat(material).join(',')
    }
  } else {
    query.materials = material
  }
  router.push({ query })
  emit('updateQuery', true)
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
  font-family: "Ubuntu", "Roboto", sans-serif;
}

.dropdown-button .chevron {
  width: 1rem;
  height: 1rem;
  margin-left: 0.5rem;
  transition: transform 0.2s ease-in-out;
}

.dropdown-button .chevron.open {
  transform: rotate(180deg);
  color: var(--primary);
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

.dropdown-list input[type="checkbox"] {
  accent-color: var(--primary);
}

.dropdown-list .selected {
  font-weight: bold;
  color: var(--primary);
}
</style>