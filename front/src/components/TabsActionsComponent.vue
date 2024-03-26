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
  border: none;
  background-color: var(--light);
  color: var(--dark);
  cursor: pointer;
}


.tabs-actions > button.tab:first-child {
  border-radius: 25px 0 0 25px;
}

.tabs-actions > button.tab:last-child {
  border-radius: 0 25px 25px 0;
}

button.tab.active {
  background-color: var(--primary);
  color: var(--light);
}
</style>