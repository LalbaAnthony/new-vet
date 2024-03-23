<template>
  <!-- Si un breadcrumb est passé en props, on l'affiche -->
  <div v-if="props.breadcrumb">
    <ol class="breadcrumb">
      <li class="el" @click="goHome">
        <IconHouse class="icon-offset" />
      </li>
      <li v-for="(crumb, index) in props.breadcrumb" :key="index">
        <IconChevronRight class="chevron" />
        <span :class="['el', crumb.active ? 'active' : '']" @click="goTo(crumb.path)">
          {{ crumb.title }}
        </span>
      </li>
    </ol>
  </div>
  <!-- sinon on génère le breadcrumb en fonction de la route actuelle. -->
  <div v-else>
    <ol class="breadcrumb">
      <li class="el" @click="goHome">
        <IconHouse class="icon-offset" />
      </li>
      <li v-for="(crumb, index) in route.matched" :key="index">
        <div
          v-if="
            index === 0 ||
            (route.matched[index - 1] &&
              route.matched[index].name !== route.matched[index - 1].name)
          "
        >
          <IconChevronRight class="chevron" />
          <span :class="['el', crumb.name == route.name ? 'active' : '']" @click="goTo(crumb.path)">
            {{ crumb.meta.title }}
          </span>
        </div>
      </li>
    </ol>
  </div>
</template>

<script setup>
import { useRoute, useRouter } from 'vue-router'
import IconHouse from '@/icons/IconHouse.vue'
import IconChevronRight from '@/icons/IconChevronRight.vue'

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