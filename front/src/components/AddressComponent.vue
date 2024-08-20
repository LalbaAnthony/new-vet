<template>
  <div>
    <div class="address-card">
      <div class="address-info">
        <div class="address-title">{{ props.address.address1 }}</div>
        <p>{{ props.address.first_name }} {{ props.address.last_name }}</p>
        <p>{{ props.address.address1 }} {{ props.address.address2 }}, {{ props.address.zip }} {{ props.address.city }}
        </p>
        <p>{{ countryName }}, {{ props.address.region }}</p>
        <p>Tél : {{ props.address.tel }}</p>
      </div>
      <div v-if="props.interaction" class="toolbar">
        <IconTrash class="address-delete-icon" @click="authStore.deleteAddress(props.address.address_id)" />
      </div>
    </div>
  </div>
</template>


<script setup>
import IconTrash from '@/icons/IconTrash.vue'
import { useAuthStore } from '@/stores/auth'
import { useCountryStore } from '@/stores/country'
import { computed } from 'vue';

const countryStore = useCountryStore()
const authStore = useAuthStore()

const props = defineProps({
  address: {
    type: Object,
    required: true,
  },
  interaction: {
    type: Boolean,
    default: true,
  },
})

// Get country name from country_id
const countryName = computed(() => {
  const country = countryStore.countries.data.find((country) => country.country_id === props.address.country_id)

  if (!country) {
    return ''
  }

  return country.name
})

</script>

<style>
.address-card {
  display: flex;
  flex-direction: column;
  gap: 1rem;
  background-color: var(--light);
  padding: 2rem;
  box-shadow: 5px 5px 15px 5px rgba(0, 0, 0, 0.1);
  border-radius: 25px;
}

.toolbar {
  display: flex;
  justify-content: end;
  align-items: center;
  gap: 0.5rem;
}

.address-delete-icon {
  background-color: var(--danger);
  border-radius: 100%;
  width: 35px;
  height: 35px;
  padding: 0.5rem;
  display: flex;
  color: var(--light);
  transition: all 0.3s;
}

.address-delete-icon:hover {
  transform: scale(1.1);
}

.address-info {
  display: flex;
  flex-direction: column;
  gap: 0.5rem;
}

.address-title {
  font-size: 1.5rem;
  font-weight: 700;
}
</style>