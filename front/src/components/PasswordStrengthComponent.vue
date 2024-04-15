<template>
  <div v-if="props.password && props.password.length > 0">
    <div v-if="requirements.length > 0" class="missing-requirements">
      <div v-for="requirement in requirements" :key="requirement" class="missing-requirement txt-danger" :style="[`animationDelay: ${requirements.indexOf(requirement) * 0.1}s`]">
        <IconXCircle />
        <span>Votre mot de passe doit contenir {{ requirement }}</span>
      </div>
    </div>
    <div v-else class="missing-requirements">
      <div class="missing-requirement txt-success">
        <CheckCircle />
        <span>Votre mot de passe est sécurisé</span>
      </div>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue'
import { missingElementsPassword } from '@/helpers/helpers.js'
import IconXCircle from '@/icons/IconXCircle.vue'
import CheckCircle from '@/icons/IconCheckCircle.vue'

const props = defineProps({
  password: {
    type: String,
    required: true
  }
})

const requirements = computed(() => {
  return missingElementsPassword(props.password)
})
</script>

<style scoped>
.missing-requirements {
  margin-top: 10px;
}

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