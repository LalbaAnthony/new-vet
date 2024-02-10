<template>
  <div class="main-center">
    <span class="message-no-item"><span class="gradient bold">Aucun</span> {{ props.what }} disponible.</span>
    <button v-if="props.back" class="button" @click="$router.go(-1)">Retour</button>
  </div>
</template>

<script setup>

const props = defineProps({
  what: {
    type: String,
    default: 'élément',
    required: false,
  },
  back: {
    type: Boolean,
    default: false,
    required: false,
  },
})
</script>

<style scoped>
.main-center {
  margin: 225px auto;
  display: flex;
  justify-content: center;
  align-items: center;
  flex-direction: column;
  gap: 1rem;
}

span.message-no-item {
  color: var(--dark);
  background-color: var(--light);
  justify-content: center;
  align-items: center;
  font-size: 1.25rem;
  font-weight: 500;
}

.bold {
  font-weight: 700;
}
</style>
