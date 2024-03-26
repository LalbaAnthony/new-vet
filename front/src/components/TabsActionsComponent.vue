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

<style scpoed>
.tabs-actions {
  display: flex;
  margin-top: 20px;
}

.tabs-actions > button.tab {
  padding: 10px 20px;
  border: 1px solid #ccc;
  border-bottom: 2px solid #ccc;
  border-top: 2px solid #ccc;
  background-color: var(--light);
  color: var(--dark);
  cursor: pointer;
}

.tabs-actions > button.tab:first-child {
  border-radius: 25px 0 0 25px;
  border-left: 2px solid #ccc;
}

.tabs-actions > button.tab:last-child {
  border-radius: 0 25px 25px 0;
  border-right: 2px solid #ccc;
}

button.tab.active {
  background-color: var(--secondary);
  color: var(--light);
}
</style>