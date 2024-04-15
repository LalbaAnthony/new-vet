<template>
  <div>
    {{ props.order }}
  </div>
</template>

<script setup>

const props = defineProps({
  order: {
    type: Object,
    required: true,
  },
})
</script>
