<template>
  <h2 class="page-title">Catégorie</h2>
  {{ route.params.slug }}
</template>

<script setup>
import { useRoute } from 'vue-router'

const route = useRoute()

</script>

<style scoped></style>
