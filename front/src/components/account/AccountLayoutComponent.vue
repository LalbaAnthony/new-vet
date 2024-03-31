<template>
  <div>
hey
  </div>
</template>

<script setup>
import { useRoute, useRouter } from 'vue-router'

const route = useRoute()
const router = useRouter()

const props = defineProps({
  breadcrumb: {
    type: Array,
    required: false
  }
})

function goHome() {
  router.push('/')
}

function goTo(route) {
  router.push(route)
}

</script>

<style scoped>
ol.breadcrumb {
  display: flex;
  justify-content: flex-start;
  align-items: center;
  padding: 0.75rem 1rem;
}

ol.breadcrumb .el {
  cursor: pointer;
  padding: 0 3px;
  font-size: 1rem;
  font-weight: 600;
}

/* derniere element */
ol.breadcrumb .active {
  position: relative;
  display: inline-block;
  background: linear-gradient(90deg, var(--secondary) 0%, var(--primary) 100%);
  -webkit-background-clip: text;
  color: transparent;
}

.chevron {
  position: relative;
  top: 2px;
}
</style>