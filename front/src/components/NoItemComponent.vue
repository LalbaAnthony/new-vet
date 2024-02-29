<template>
  <div class="center">
    <p><span class="gradient bold">Aucune</span> {{ props.what }} trouvé</p>
    <div class="button-bloc">
      <router-link :to="props.cta.to" class="button">{{ props.cta.text }}</router-link>
    </div>
  </div>
</template>

<script setup>

const props = defineProps({
  what: {
    type: String,
    default: 'élément',
    required: false,
  },
  cta: {
    type: Object,
    default: () => ({ text: 'Accueil', to: '/' }),
    required: false
  }
})
</script>

<style scoped>
.center {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  height: 50vh;
}

.center p {
  font-size: 1rem;
  margin-bottom: 1.5rem;
}

.button-bloc {
  display: flex;
  gap: 1rem;
}

.bold {
  font-weight: 700;
}
</style>
