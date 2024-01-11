<template>
  <div class="main-center">
    <span class="message-no-item"><span class="gradient bold">Aucun</span> {{ what }} disponible.</span>
  </div>
</template>

<script setup>

defineProps({
  what: {
    type: String,
    default: 'élément',
    required: false,
  },
})
</script>

<style scoped>
.main-center {
  margin: 175px;
  display: flex;
  justify-content: center;
  align-items: center;
}

span.message-no-item {
  color: var(--dark);
  background-color: var(--light);
  justify-content: center;
  align-items: center;
  font-size: 1rem;
  font-weight: 500;
}

.bold {
  font-weight: 700;
}
</style>
