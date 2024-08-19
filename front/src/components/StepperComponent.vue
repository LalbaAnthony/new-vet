<template>
  <div>
    <div class="wrapper-stepper">
      <ul class="stepper">
        <li v-for="step in props.steps" :class="[step.active || step.completed ? 'active' : '']"
          :style="[props.steps.length > 1 ? `width:${100 / props.steps.length}%` : '']" :key="step.name"
          @click="() => { if (props.interaction) { step.action() } }">
          <span v-if="(isMobile() && step.active) || !isMobile()">{{ step.name }}</span>
        </li>
      </ul>
    </div>
    <br>
    <br>
    <br>
  </div>
</template>

<script setup>
import { isMobile } from '@/helpers/helpers.js'

const props = defineProps({
  steps: {
    type: Object,
    required: true,
  },
  interaction: {
    type: Boolean,
    default: true,
  },
})
</script>

<style scoped>
.wrapper-stepper {
  width: 100%
}

.stepper {}

.stepper li {
  list-style-type: none;
  float: left;
  position: relative;
  text-align: center;
}

.stepper li:before {
  content: " ";
  line-height: 30px;
  border-radius: 50%;
  width: 30px;
  height: 30px;
  border: 3px solid var(--gray);
  display: block;
  text-align: center;
  margin: 0 auto 10px;
  background-color: var(--light)
}

.stepper li:after {
  content: "";
  position: absolute;
  width: 100%;
  height: 4px;
  background-color: var(--gray);
  top: 15px;
  left: -50%;
  z-index: -1;
}

.stepper li:first-child:after {
  content: none;
}

.stepper li.active {
  color: var(--primary);
}

.stepper li.active:before {
  border-color: var(--primary);
  background-color: var(--primary)
}

.stepper .active:after {
  background-color: var(--primary);
}
</style>
