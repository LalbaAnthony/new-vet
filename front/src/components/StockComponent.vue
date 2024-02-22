<template>
  <div>
    <div v-if="props.stock > 10">
      <span class="stock high">En stock</span>
    </div>
    <div v-else-if="props.stock > 0">
      <span class="stock medium">Plus que {{ props.stock }} en stock !</span>
    </div>
    <div v-else>
      <span class="stock low">En rupture</span>
    </div>
  </div>
</template>

<script setup>

const props = defineProps({
  stock: {
    type: Number,
    required: true,
  },
})
</script>

<style scoped>
span.stock {
  display: inline-block;
  font-size: 15px;
  font-weight: 600;
  margin: 0.25rem 0;
}

span.stock.high {
  color: var(--success);
}

span.stock.medium {
  color: var(--warning);
}

span.stock.low {
  color: var(--danger);
}
</style>
