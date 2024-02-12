<template>
  <div class="pagination-bloc">
    <IconChevronLeft class="arrow left" />
    <div class="number" v-for="i in totalOrThree()" :key="i" :class="['number', page === i ? 'active' : '']"
      @click="page = i">{{ i }}</div>
    <div v-if="total > 4">...</div>
    <div v-if="total > 3" class="number">{{ total }}</div>
    <IconChevronRight class="arrow right" />
  </div>
</template>

<script setup>
import { ref } from 'vue'
import IconChevronLeft from '@/components/icons/IconChevronLeft.vue'
import IconChevronRight from '@/components/icons/IconChevronRight.vue'

const page = ref(1)
const perPage = ref(8)
const total = ref(10)

function totalOrThree() {
  return total.value > 3 ? 3 : total.value
}

</script>

<style scoped>
.pagination-bloc {
  display: flex;
  justify-content: center;
  align-items: center;
  gap: 1rem;
  margin-top: 2rem;
}

.pagination-bloc>.arrow {
  cursor: pointer;
  height: 20px;
  width: 20px;
  transition: transform 0.3s;
}

.pagination-bloc>.arrow:hover {
  color: var(--primary);
}

.pagination-bloc>.arrow.left:hover {
  transform: translateX(-4px);
}

.pagination-bloc>.arrow.right:hover {
  transform: translateX(4px);
}

.pagination-bloc>.number {
  cursor: pointer;
  transition: color 0.3s;
}

.pagination-bloc>.number.active {
  color: var(--primary);
}
</style>