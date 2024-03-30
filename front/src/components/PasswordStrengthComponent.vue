<template>
  <div class="missing-requirements" v-if="props.password && props.password.length > 0">
    <div v-if="missings.length > 0">
      <div v-for="requirement in missings" :key="requirement" class="missing-requirement danger">
        <IconXCircle />
        <span>Votre mot de passe doit contenir {{ requirement }}</span>
      </div>
    </div>
    <div v-else>
      <div class="missing-requirement success">
        <CheckCircle />
        <span>Votre mot de passe est sécurisé</span>
      </div>
    </div>
  </div>
</template>

<script setup>
import { defineProps, computed } from 'vue'
import { missingElementsPassword } from '@/helpers/helpers.js'
import IconXCircle from '@/icons/IconXCircle.vue'
import CheckCircle from '@/icons/IconCheckCircle.vue'

const props = defineProps({
  password: {
    type: String,
    required: true
  }
})

const missings = computed(() => {
  return missingElementsPassword(props.password)
})
</script>

<style scoped>

.missing-requirement {
  display: flex;
  align-items: center;
  gap: 5px;
  margin-top: 5px;
  animation-name: slidFromLeft;
  animation-duration: 0.5s;
}

@keyframes slidFromLeft {
  from {
    opacity: 0;
    transform: translateX(-50px);
  }
  to {
    opacity: 1;
    transform: translateX(0);
  }
}
</style>