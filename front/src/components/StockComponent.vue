<template>
  <div>
    <div v-if="stock > 10">
      <span class="stock stock-high">En stock</span>
    </div>
    <div v-else-if="stock > 0">
      <span class="stock stock-medium">Plus que {{ stock }} !</span>
    </div>
    <div v-else>
      <span class="stock stock-low">En rupture</span>
    </div>
  </div>
</template>

<script setup>

defineProps({
  stock: {
    type: Number,
    required: true,
  },
})
</script>

<style scoped>

span.stock {
  color: var(--light);
  display: inline-block;
  padding: 0 10px;
  font-size: 12px;
  border-radius: 50px;
  margin: 0.25rem;
}

span.stock-high {
  background-color: var(--success);
}

span.stock-medium {
  background-color: var(--warning);
}

span.stock-low {
  background-color: var(--danger);
}

</style>
