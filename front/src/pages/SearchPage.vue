<template>
  <div>
    <h2 class="page-title">Recherche</h2>
    <span>
      Recherche: {{ route.params.searched }}
    </span>
  </div>
</template>

<script setup>
import { useRoute } from 'vue-router'

const route = useRoute()

</script>

<style scoped></style>
