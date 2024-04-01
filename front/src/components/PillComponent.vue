<template>
  <div>
    <div v-if="props.link">
      <router-link :to="props.link">
        <div :class="['pill-body hover-effect', props.type]">
          <span :class="['pill-text', props.type]">{{ threeDotString(props.text, 40) }}</span>
        </div>
      </router-link>
    </div>
    <div v-else>
      <div :class="['pill-body', props.type]">
        <span :class="['pill-text', props.type]">{{ threeDotString(props.text, 40) }}</span>
      </div>
    </div>
  </div>
</template>

<script setup>
import { threeDotString } from '@/helpers/helpers.js'

const props = defineProps({
  text: {
    type: String,
    required: true,
  },
  link: {
    type: String,
    required: false,
  },
  type: {
    type: String,
    default: 'gradient',
    required: false,
  },
})
</script>

<style scoped>
div.pill-body {
  display: inline-block;
  padding: 3px 10px;
  font-size: 12px;
  border-radius: 25px;
  margin: 0.5rem;
}

div.pill-body.hover-effect:hover {
  cursor: pointer;
  transform: scale(1.05);
  transition: all 0.3s;
}

span.pill-text {
  font-weight: 500;
}

div.pill-body.light {
  background-color: var(--light);
}

div.pill-body.gradient {
  background: var(--secondary);
  background: linear-gradient(90deg, var(--secondary) 0%, var(--primary) 100%);
}

span.pill-text.gradient {
  color: var(--light);
}

span.pill-text.light {
  position: relative;
  display: inline-block;
  background: linear-gradient(90deg, var(--secondary) 0%, var(--primary) 100%);
  background-clip: text;
  color: transparent;
}
</style>
