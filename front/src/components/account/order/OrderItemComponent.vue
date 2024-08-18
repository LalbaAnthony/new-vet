<template>
  <div class="order-item">
    <div class="order-item__content">
      <div class="order-item__date">
        <span class="badge" :style="['color: var(--light)]', `background-color: ${props.order.status.color}`]">
          {{ props.order.status.libelle }}
        </span>
      </div>
      <div class="order-item__id">
        <span>ID de commande #{{ props.order.order_id }}</span>
      </div>
      <p v-if="props.order.status.status_id == 3" class="order-item__description">
        Votre a été livré à {{ niceShippingAddress }}
      </p>
      <p v-else class="order-item__description">
        Votre coli sera livré à {{ niceShippingAddress }}
      </p>
    </div>
    <div class="order-item__ctas">
      <button class="button" @click="$router.push(`/mon-compte/mes-commandes/${props.order.order_id}`)">
        Détails
      </button>
      <button class="button outline"  @click="$router.push(`/contact?sujet=Problème au sujet de la commande N°${props.order.order_id}`)">
        Signaler
      </button>
    </div>

    <!-- {{ props.order }} -->
  </div>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  order: {
    type: Object,
    required: true,
  },
})

const niceShippingAddress = computed(() => {
  let address = ''
  if (props.order.shipping_address) {
    if(props.order.shipping_address.address1) address += `${props.order.shipping_address.address1}, `
    if(props.order.shipping_address.address2) address += `${props.order.shipping_address.address2}, `
    if(props.order.shipping_address.zip) address += `${props.order.shipping_address.zip} `
    if(props.order.shipping_address.city) address += `${props.order.shipping_address.city}`
    if(props.order.shipping_address.country) address += `, ${props.order.shipping_address.country.name}`
  }
  return address
})

const niceBillingAddress = computed(() => {
  let address = ''
  if (props.order.billing_address) {
    if(props.order.billing_address.address1) address += `${props.order.billing_address.address1}, `
    if(props.order.billing_address.address2) address += `${props.order.billing_address.address2}, `
    if(props.order.billing_address.zip) address += `${props.order.billing_address.zip} `
    if(props.order.billing_address.city) address += `${props.order.billing_address.city}`
    if(props.order.billing_address.country) address += `, ${props.order.billing_address.country.name}`
  }
  return address
})

</script>

<style scoped>
.order-item {
  color: var(--dark);
  overflow: hidden;
  background-color: var(--light);
  box-shadow: 3px 3px 15px 3px rgba(0, 0, 0, 0.1);
  border-radius: 25px;
  display: flex;
  justify-content: space-around;
  align-items: center;
  gap: 1rem;
  padding: 1rem;
}

.order-item__date {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  padding: 0.25rem 0;
  font-size: 1rem;
  font-weight: 700;
}

.order-item__id {
  font-weight: 700;
  color: var(--gray);
}

.order-item__ctas {
  display: flex;
  flex-direction: column;
  gap: 1rem;
  justify-content: space-between;
}
</style>
