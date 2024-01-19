<template>
  <h2 class="page-title">Recherche</h2>
  Recherche: {{ route.params.searched }}
</template>

<script setup>
import { useRoute } from 'vue-router'

const route = useRoute()

</script>

<style scoped></style>
