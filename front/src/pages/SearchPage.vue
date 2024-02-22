<template>
  <div>
    <h2 class="page-title">Recherche</h2>
    <Breadcrumb />
    <span>
      Recherche: {{ route.query.search }}
    </span>
  </div>
</template>

<script setup>
import Breadcrumb from '@/components/BreadcrumbComponent.vue'
import { useRoute } from 'vue-router'

const route = useRoute()

</script>

<style scoped></style>
