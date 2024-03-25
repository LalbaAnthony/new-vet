<template>
  <div>
    <div class="darken-background" v-if="authStore.authModal.show" @click="authStore.toggleModal()"></div>
    <div class="main-display" v-if="authStore.authModal.show">
      {{ authStore.authModal }}
      <button class="main-display-close" @click="authStore.toggleModal()">
        <IconX />
      </button>
    </div>
  </div>
</template>

<script setup>
// import { ref } from 'vue'
import IconX from '@/icons/IconX.vue'
import { useAuthStore } from '@/stores/auth'

const authStore = useAuthStore()

</script>

<style scoped>

.darken-background {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: inherit;
  background-color: rgba(0, 0, 0, 0.75);
  z-index: 999;
}

.main-display {
  background-color: var(--light);
  border-radius: 20px;
  width: 500px;
  max-width: 90%;
  position: fixed;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  box-shadow: 1px 1px 20px 1px rgba(0, 0, 0, 0.1);
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  gap: 1rem;
  padding: 2rem;
  z-index: 1000;
}

button.main-display-close {
  position: absolute;
  top: 1rem;
  right: 1rem;
  background-color: var(--dark);
  color: var(--light);
  border: none;
  border-radius: 50%;
  padding: 0.5rem;
  cursor: pointer;
}

button.main-display-close>svg {
  width: 20px;
  height: 20px;
  transform: translate(0, 2px);
}

</style>