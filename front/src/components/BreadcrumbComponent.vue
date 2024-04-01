<template>
  <ol class="breadcrumb" v-if="route.meta.breadcrumb">
    <li>
      <IconHouse class="icon-offset clickable" @click="goHome" />
    </li>
    <li v-for="(crumb, index) in route.meta.breadcrumb" :key="index">
        <IconChevronRight class="chevron" />
        <span :class="['el', crumb.active ? 'active' : '']" @click="crumb.path ? goTo(crumb.path) : null">
          {{ crumb.title }}
        </span>
    </li>
  </ol>
</template>

<script setup>
import { useRoute, useRouter } from 'vue-router'
import IconHouse from '@/icons/IconHouse.vue'
import IconChevronRight from '@/icons/IconChevronRight.vue'

const route = useRoute()
const router = useRouter()

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

.chevron {
  position: relative;
  top: 2px;
}

ol.breadcrumb .el {
  cursor: pointer;
  padding: 0 3px;
  font-size: 1rem;
  font-weight: 600;
}

ol.breadcrumb .active {
  position: relative;
  display: inline-block;
  background: linear-gradient(90deg, var(--secondary) 0%, var(--primary) 100%);
  background-clip: text;
  color: transparent;
}
</style>