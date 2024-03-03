<template>
  <div v-if="props.total > 1" class="pagination-bloc">
    <IconChevronLeft class="arrow left" @click="$emit('updatePage', (props.page > 1 ? props.page - 1 : 1) || 1)" />

    <!-- Page 1 -->
    <div v-if="props.page > 2" class="number" @click="$emit('updatePage', 1)"> 1 </div>
    <div v-if="props.page > 3"> ... </div>

    <!-- Page précedente -->
    <div v-if="props.page > 1" class="number" @click="$emit('updatePage', props.page - 1)">
      {{ props.page - 1 }}
    </div>

    <!-- Page actuelle -->
    <div class="number active">{{ props.page }}</div>

    <!-- Page suivante -->
    <div v-if="props.page < props.total" class="number" @click="$emit('updatePage', props.page + 1)">
      {{ props.page + 1 }}
    </div>

    <!-- Derniere page -->
    <div v-if="props.page < props.total - 2"> ... </div>
    <div v-if="props.page < props.total - 1" class="number" @click="$emit('updatePage', props.total)">
      {{ props.total }}
    </div>

    <IconChevronRight class="arrow right"
      @click="$emit('updatePage', (props.page < props.total ? props.page + 1 : props.total) || 1)" />
  </div>
</template>

<script setup>
import IconChevronLeft from '@/icons/IconChevronLeft.vue'
import IconChevronRight from '@/icons/IconChevronRight.vue'

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