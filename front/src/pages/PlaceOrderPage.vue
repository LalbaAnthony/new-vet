<template>
  <div>
    <h2 class="page-title">Passer la commande</h2>
    <!-- Stepper, cannot be used in the confirmation step cuz the commande is already placed -->
    <Stepper :steps="steps" :interaction="authStore.placeOrderFunnel.currentStep !== 'confirmation'" />

    <!-- Address -->
    <section v-if="authStore.placeOrderFunnel.currentStep === 'address'">
      <h3 class="section-title">{{ authStore.placeOrderFunnel.steps[authStore.placeOrderFunnel.currentStep].name }}</h3>

      <div class="select-bar">
        <div class="form-group">
          <label for="shipping_address_id" class="required">Adresse de livraison</label>
          <select v-if="authStore.addresses.data.length > 0"
            v-model="authStore.placeOrderFunnel.order.shipping_address_id" id="shipping_address_id">
            <option v-for="address in authStore.addresses.data" :key="address.address_id" :value="address.address_id">
              {{ address.address1 }} {{ address.address2 }}, {{ address.city }}
            </option>
          </select>
        </div>
        <div class="form-group">
          <label for="billing_address_id" class="required">Adresse de livraison</label>
          <select v-if="authStore.addresses.data.length > 0"
            v-model="authStore.placeOrderFunnel.order.billing_address_id" id="billing_address_id">
            <option v-for="address in authStore.addresses.data" :key="address.address_id" :value="address.address_id">
              {{ address.address1 }} {{ address.address2 }}, {{ address.city }}
            </option>
          </select>
        </div>
        <div class="form-group">
          <p>Une autre adresse ?</p>
          <AddressAddModalButton />
        </div>
      </div>

      <section class="stepper-control" v-if="authStore.placeOrderFunnel.currentStep !== 'confirmation'">
        <button @click="previousStep" class="button"
          :disabled="authStore.placeOrderFunnel.currentStep === 'address'">Précédent</button>
        <button @click="nextStep" class="button"
          :disabled="authStore.placeOrderFunnel.currentStep === 'confirmation'">Suivant</button>
      </section>
    </section>

    <!-- Payment -->
    <section v-if="authStore.placeOrderFunnel.currentStep === 'payment'">
      <h3 class="section-title">{{ authStore.placeOrderFunnel.steps[authStore.placeOrderFunnel.currentStep].name }}</h3>

      <div class="select-bar">
        <div class="form-group">
          <label for="card_id" class="required">Moyen de paiment</label>
          <select v-if="authStore.cards.data.length > 0"
            v-model="authStore.placeOrderFunnel.order.card_id" id="card_id">
            <option v-for="card in authStore.cards.data" :key="card.card_id" :value="card.card_id">
              {{ card.number }} 
            </option>
          </select>
        </div>
        <div class="form-group">
          <p>Une autre carte ?</p>
          <CardAddModalButton />
        </div>
      </div>

      <section class="stepper-control" v-if="authStore.placeOrderFunnel.currentStep !== 'confirmation'">
        <button @click="previousStep" class="button"
          :disabled="authStore.placeOrderFunnel.currentStep === 'address'">Précédent</button>
        <button @click="nextStep" class="button"
          :disabled="authStore.placeOrderFunnel.currentStep === 'confirmation'">Suivant</button>
      </section>
    </section>

    <!-- Summary -->
    <section v-if="authStore.placeOrderFunnel.currentStep === 'summary'">
      <h3 class="section-title">{{ authStore.placeOrderFunnel.steps[authStore.placeOrderFunnel.currentStep].name }}</h3>

      <!-- ... -->

      <section class="stepper-control" v-if="authStore.placeOrderFunnel.currentStep !== 'confirmation'">
        <button @click="previousStep" class="button"
          :disabled="authStore.placeOrderFunnel.currentStep === 'address'">Précédent</button>
        <button @click="nextStep" class="button"
          :disabled="authStore.placeOrderFunnel.currentStep === 'confirmation'">Suivant</button>
      </section>
    </section>

    <!-- Confirmation -->
    <section v-if="authStore.placeOrderFunnel.currentStep === 'confirmation'">
      <h3 class="section-title">{{ authStore.placeOrderFunnel.steps[authStore.placeOrderFunnel.currentStep].name }}</h3>
      <Confirmation />
    </section>
  </div>
</template>

<script setup>
import Stepper from '@/components/StepperComponent.vue'
import AddressAddModalButton from '@/components/account/AddressAddModalButtonComponent.vue'
import CardAddModalButton from '@/components/account/CardAddModalButtonComponent.vue'
import { useAuthStore } from '@/stores/auth'
import { computed } from 'vue';

const authStore = useAuthStore()

if (authStore.addresses.data.length > 0) {
  authStore.fetchAddresses()
}

if (authStore.cards.data.length > 0) {
  authStore.fetchCards()
}

function previousStep() {
  const stepsArray = Object.keys(authStore.placeOrderFunnel.steps);
  const currentStepIndex = stepsArray.indexOf(authStore.placeOrderFunnel.currentStep);
  if (currentStepIndex > 0) {
    authStore.placeOrderFunnel.currentStep = stepsArray[currentStepIndex - 1];
  }
}

function nextStep() {
  const stepsArray = Object.keys(authStore.placeOrderFunnel.steps);
  const currentStepIndex = stepsArray.indexOf(authStore.placeOrderFunnel.currentStep);
  if (currentStepIndex < stepsArray.length - 1) {
    authStore.placeOrderFunnel.currentStep = stepsArray[currentStepIndex + 1];
  }
}

const steps = computed(() => {
  const stepsArray = Object.keys(authStore.placeOrderFunnel.steps).map((stepKey, index, array) => {
    const currentStepIndex = array.indexOf(authStore.placeOrderFunnel.currentStep);
    return {
      name: authStore.placeOrderFunnel.steps[stepKey].shortName,
      active: index === currentStepIndex,
      completed: index < currentStepIndex,
      action: () => {
        if (index > currentStepIndex) return;
        authStore.placeOrderFunnel.currentStep = stepKey;
      },
    };
  });
  return stepsArray
})

</script>

<style scoped>
.stepper-control {
  display: flex;
  justify-content: space-between;
  margin-top: 20px;
}

.select-bar {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
  gap: 1rem;
  align-items: center;
  margin: 1.5rem;
}
</style>
