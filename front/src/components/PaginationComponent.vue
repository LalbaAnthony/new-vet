<template>
  <div class="pagination-bloc">
    <IconChevronLeft class="arrow left" />
    <div class="number">1</div>
    <div class="number active">2</div>
    <div class="number">3</div>
    <div>...</div>
    <div class="number">10</div>
    <IconChevronRight class="arrow right" />
  </div>
</template>

<script setup>
import IconChevronLeft from '@/components/icons/IconChevronLeft.vue'
import IconChevronRight from '@/components/icons/IconChevronRight.vue'

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

.pagination-block>.number {
  cursor: pointer;
  transition: color 0.3s;
}

.pagination-block>.number.active {
  color: var(--primary);
}
</style>