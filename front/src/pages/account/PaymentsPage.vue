<template>
  <div>
    <h2 class="page-title">Mes moyens de paiement</h2>
    <Breadcrumb />
    <AccountLayout />
    <Loader v-if="authStore.cards.loading" />
    <div v-else>
      <div class="card-actions">
            <button class="button" @click="router.push('/paiment')">Ajouter</button>
          </div>
      <div v-if="authStore.cards.data && authStore.cards.data.length > 0">
        <div class="cards-grid">
          <CreditCard v-for="card in authStore.cards.data" :key="card.card_id" :card="card" />
        </div>
      </div>
      <NoItem v-else />
    </div>
  </div>
</template>

<script setup>
import NoItem from '@/components/NoItemComponent.vue'
import Breadcrumb from '@/components/BreadcrumbComponent.vue'
import CreditCard from '@/components/CreditCardComponent.vue'
import AccountLayout from '@/components/account/AccountLayoutComponent.vue'
import { useAuthStore } from '@/stores/auth'

const authStore = useAuthStore()
authStore.fetchCards()

</script>

<style scoped>
.cards-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
  gap: 20px;
}

.card-actions {
  display: flex;
  justify-content: end;
  align-items: center;
  gap: 0.5rem;
}
</style>