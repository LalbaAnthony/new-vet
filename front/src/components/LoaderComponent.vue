<template>
  <div v-if="props.enabled" class="main-center">
    <span class="loader"></span>
  </div>
</template>

<script setup>

const props = defineProps({
  enabled: {
    type: Boolean,
    default: true,
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
}

.loader {
  width: 84px;
  height: 84px;
  position: relative;
}

.loader:before,
.loader:after {
  content: "";
  position: absolute;
  left: 50%;
  bottom: 0;
  width: 64px;
  height: 64px;
  border-radius: 50%;
  background: var(--secondary);
  background: linear-gradient(90deg, var(--secondary) 0%, var(--primary) 100%);
  transform: translate(-50%, -100%) scale(0);
  animation: push 2s infinite linear;
}

.loader:after {
  animation-delay: 1s;
}

@keyframes push {

  0%,
  50% {
    transform: translate(-50%, 0%) scale(1)
  }

  100% {
    transform: translate(-50%, -100%) scale(0)
  }
}</style>
