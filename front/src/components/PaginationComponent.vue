<template>
  <div class="pagination-bloc">
    <IconChevronLeft class="arrow left" />
    <div class="number" v-for="i in totalOrThree()" :key="i" :class="['number', props.page === i ? 'active' : '']"
      @click="$emit('updatePage', i)">{{ i }}</div>
    <div v-if="props.total && props.total > 4">...</div>
    <div v-if="props.total && props.total > 3" @click="$emit('updatePage', props.total)" class="number">{{ props.total }}
    </div>
    <IconChevronRight class="arrow right" />
  </div>
</template>

<script setup>
import IconChevronLeft from '@/components/icons/IconChevronLeft.vue'
import IconChevronRight from '@/components/icons/IconChevronRight.vue'

const props = defineProps({
  total: {
    type: Number,
    required: false,
  },
  page: {
    type: Number,
    default: 1,
    required: false,
  },
  perPage: {
    type: Number,
    default: 10,
    required: true,
  },

})

function totalOrThree() {
  if (!props.total) return 3
  return props.total.value > 3 ? 3 : props.total.value
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