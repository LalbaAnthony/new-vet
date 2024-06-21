<template>
  <div class="order-item">
    <div class="order-item__content">
      <div class="order-item__date">
        <span class="success badge">
          Livré
        </span>
        le 14 mai
      </div>
      <div class="order-item__id">
        <span>ID de commande #{{ props.order.order_id }}</span>
      </div>
      <p class="order-item__description">
        Votre coli est arrivé à destination au Adresse, Ville, Pays.
      </p>
    </div>
    <div class="order-item__ctas">
      <button class="button" @click="console.log('clicked')">
        Détails
      </button>
      <button class="button outline" @click="console.log('clicked')">
        Voir le produit
      </button>
    </div>
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
