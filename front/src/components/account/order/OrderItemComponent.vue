<template>
  <div class="order-item">
    {{ props.order }}
  </div>
</template>

<script setup>

const props = defineProps({
  order: {
    type: Object,
    required: true,
  },
})
</script>

<style scoped>
.order-item {
  color: var(--dark);
  overflow: hidden;
  background-color: var(--light);
  box-shadow: 3px 3px 15px 3px rgba(0, 0, 0, 0.1);
  border-radius: 25px;
  display: flex;
  justify-content: space-between;
  align-items: center;
  gap: 1rem;
  padding: 1rem;
}
</style>
