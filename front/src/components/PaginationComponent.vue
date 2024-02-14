<template>
  <div class="pagination-bloc">
    <IconChevronLeft class="arrow left" @click="$emit('updatePage', (props.page > 1 ? props.page - 1 : 1) || 1)" />
    <div class="number" v-for="i in totalOrThree()" :key="i" :class="['number', props.page === i ? 'active' : '']"
      @click="$emit('updatePage', i)">{{ i }}</div>
    <div v-if="props.total && props.total > 3">...</div>
    <div v-if="props.total && props.total > 3" @click="$emit('updatePage', props.total)" class="number">{{ props.total }}
    </div>
    <IconChevronRight class="arrow right"
      @click="$emit('updatePage', (props.page < props.total ? props.page + 1 : props.total) || 1)" />
  </div>
</template>

<script setup>
import IconChevronLeft from '@/components/icons/IconChevronLeft.vue'
import IconChevronRight from '@/components/icons/IconChevronRight.vue'

const props = defineProps({
  total: {
    type: Number,
    required: true,
  },
  page: {
    type: Number,
    required: true,
  },
  perPage: {
    type: Number,
    required: true,
  },

})

function totalOrThree() {
  return props.total > 3 ? 3 : props.total
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