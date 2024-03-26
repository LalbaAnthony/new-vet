<template>
  <div class="tabs-actions">
    <button
      v-for="(tab, index) in props.tabs"
      :key="index"
      @click="tab.action"
      :class="['tab', tab.active ? 'active' : '']"
    >
      {{ tab.title }}
    </button>
  </div>
</template>

<script setup>
const props = defineProps({
  tabs: {
    type: Array,
    required: true
  }
})
</script>

<style scoped>
.tabs-actions {
  display: flex;
}

.tabs-actions > button.tab {
  padding: 10px 20px;
  border: 1px solid var(--secondary);
  border-bottom: 2px solid var(--secondary);
  border-top: 2px solid var(--secondary);
  background-color: var(--light);
  color: var(--secondary);
  cursor: pointer;
}

.tabs-actions > button.tab:first-child {
  border-radius: 25px 0 0 25px;
  border-left: 2px solid var(--secondary);
}

.tabs-actions > button.tab:last-child {
  border-radius: 0 25px 25px 0;
  border-right: 2px solid var(--secondary);
}

button.tab.active {
  background: var(--secondary);
  background: linear-gradient(90deg, var(--secondary) 0%, var(--primary) 100%);
  color: var(--light);
}
</style>