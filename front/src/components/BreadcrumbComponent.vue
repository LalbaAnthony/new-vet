<template>
  <div>
    <!-- <ol class="breadcrumb">
      <li class="el" @click="goHome">
        <IconHouse class="icon-offset" />
      </li>
      <li v-for="(crumb, index) in route.matched" :key="index">
        <IconChevronRight class="chevron" />
        <span :class="['el', crumb.name == route.name ? 'active' : '']" @click="goTo(crumb.path)">
          {{ crumb.path.includes("slug") && route.params.slug ? route.params.slug : crumb.meta.title }}
        </span>
      </li>
    </ol> -->
    <!-- <pre>
      {{ route }}
    </pre> -->
  </div>
</template>


<script setup>
import { useRoute, useRouter } from 'vue-router'
import IconHouse from '@/components/icons/IconHouse.vue'
import IconChevronRight from '@/components/icons/IconChevronRight.vue'

const route = useRoute()
const router = useRouter()

function goHome() {
  router.push('/')
}

function goTo(route) {
  router.push(route)
}

function goBack() {
  router.go(-1)
}

function goForward() {
  router.go(1)
}

</script>

<style scoped>
ol.breadcrumb {
  display: flex;
  justify-content: flex-start;
  align-items: center;
  padding: 0.75rem 1rem;
  margin-bottom: 1rem;
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