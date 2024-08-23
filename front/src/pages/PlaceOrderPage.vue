<template>
  <div>
    <h2 class="page-title">Passer la commande</h2>
    <!-- Stepper, cannot be used in the confirmation step cuz the commande is already placed -->
    <Stepper :steps="steps" :interaction="authStore.placeOrderFunnel.currentStep !== 'confirmation'" />

    <Loader v-if="authStore.placeOrderFunnel.loading" />

    <div v-else>
      <!-- Address -->
      <section v-if="authStore.placeOrderFunnel.currentStep === 'address'" class="place-order-section">
        <h3 class="section-title">{{ authStore.placeOrderFunnel.steps[authStore.placeOrderFunnel.currentStep].name }}
        </h3>

        <div class="select-bar">
          <div v-if="authStore.addresses.data.length > 0" class="form-group">
            <label for="shipping_address_id" class="required">Adresse de livraison</label>
            <select v-model="authStore.placeOrderFunnel.order.shipping_address_id" id="shipping_address_id">
              <option v-for="address in authStore.addresses.data" :key="address.address_id" :value="address.address_id">
                {{ address.address1 }} {{ address.address2 }}, {{ address.city }}
              </option>
            </select>
          </div>
          <div v-if="authStore.addresses.data.length > 0" class="form-group">
            <label for="billing_address_id" class="required">Adresse de livraison</label>
            <select v-model="authStore.placeOrderFunnel.order.billing_address_id" id="billing_address_id">
              <option v-for="address in authStore.addresses.data" :key="address.address_id" :value="address.address_id">
                {{ address.address1 }} {{ address.address2 }}, {{ address.city }}
              </option>
            </select>
          </div>
          <div class="form-group">
            <p v-if="authStore.addresses.data.length > 0">Une autre adresse ?</p>
            <AddressAddModalButton />
          </div>
        </div>

        <div class="stepper-control">
          <button @click="previousStep" class="button" :disabled="true">Précédent</button>
          <button @click="nextStep" class="button" :disabled="!canClickNextAddress">Suivant</button>
        </div>
      </section>

      <!-- Payment -->
      <section v-if="authStore.placeOrderFunnel.currentStep === 'payment'" class="place-order-section">
        <h3 class="section-title">{{ authStore.placeOrderFunnel.steps[authStore.placeOrderFunnel.currentStep].name }}
        </h3>

        <div class="select-bar">
          <div v-if="authStore.cards.data.length > 0" class="form-group">
            <label for="card_id" class="required">Moyen de paiment</label>
            <select v-model="authStore.placeOrderFunnel.order.card_id" id="card_id">
              <option v-for="card in authStore.cards.data" :key="card.card_id" :value="card.card_id">
                {{ card.number }}
              </option>
            </select>
          </div>
          <div class="form-group">
            <p v-if="authStore.cards.data.length > 0">Une autre carte ?</p>
            <CardAddModalButton />
          </div>
        </div>

        <div class="stepper-control" v-if="authStore.placeOrderFunnel.currentStep !== 'confirmation'">
          <button @click="previousStep" class="button" :disabled="false">Précédent</button>
          <button @click="nextStep" class="button" :disabled="!canClickNextPayment">Suivant</button>
        </div>
      </section>

      <!-- Summary -->
      <section v-if="authStore.placeOrderFunnel.currentStep === 'summary'" class="place-order-section">
        <h3 class="section-title">{{ authStore.placeOrderFunnel.steps[authStore.placeOrderFunnel.currentStep].name }}
        </h3>

        <div class="products-summary">
          <div class="summary-infos">
            <span class="summary-infos-total">Total: {{ roundNb(productStore.cartProductsTotalPrice) }} €</span>
          </div>

          <div class="products-grid">
            <CartItem v-for="product in productStore.cartProducts.data" :key="product.slug" :interaction="false"
              :product="product" @reload-cart="reloadProductStoreCart()" />
          </div>
        </div>

        <div class="address-grid">
          <div>
            <div class="address-grid-title">Adresse de livraison</div>
            <Address :address="selectedShippingAddress" :interaction="false" />
          </div>
          <div>
            <div class="address-grid-title">Adresse de facturation</div>
            <Address :address="selectedBillingAddress" :interaction="false" />
          </div>
        </div>

        <div class="card-grid">
          <div class="address-grid-title">Moyen de paiment</div>
          <div>
            <CreditCard :card="selectedCard" :interaction="false" />
          </div>
        </div>

        <div class="stepper-control">
          <button @click="previousStep" class="button" :disabled="false">Précédent</button>
          <button @click="nextStep; authStore.placeOrder()" class="button" :disabled="false">Payer et
            commander</button>
        </div>
      </section>

      <!-- Confirmation -->
      <section v-if="authStore.placeOrderFunnel.currentStep === 'confirmation'" class="place-order-section">
        <h3 class="section-title">{{ authStore.placeOrderFunnel.steps[authStore.placeOrderFunnel.currentStep].name }}
        </h3>
      </section>
    </div>
  </div>
</template>

<script setup>
import Stepper from '@/components/StepperComponent.vue'
import CartItem from '@/components/cart/CartItemComponent.vue'
import AddressAddModalButton from '@/components/account/AddressAddModalButtonComponent.vue'
import CardAddModalButton from '@/components/account/CardAddModalButtonComponent.vue'
import Address from '@/components/AddressComponent.vue'
import CreditCard from '@/components/CreditCardComponent.vue'
import Loader from '@/components/LoaderComponent.vue'
import { useAuthStore } from '@/stores/auth'
import { useProductStore } from '@/stores/product'
import { computed } from 'vue'
import router from '@/router';
import { roundNb } from '@/helpers/helpers.js'

const authStore = useAuthStore()
const productStore = useProductStore()

authStore.fetchAddresses()
authStore.fetchCards()

if (authStore.cart.length === 0) {
  router.push('/panier')
} else {
  if (productStore.cartProducts.data.length === 0) {
    productStore.fetchCartProducts()
  }
}

const canClickNextAddress = computed(() => {
  const completed = (authStore.placeOrderFunnel.order.shipping_address_id !== null) && (authStore.placeOrderFunnel.order.billing_address_id !== null)

  if (completed) {
    return true
  }

  return false
})

const canClickNextPayment = computed(() => {
  const completed = (authStore.placeOrderFunnel.order.card_id !== null)

  if (completed) {
    return true
  }

  return false
})

// Get card name from card_id
const selectedCard = computed(() => {
  const card = authStore.cards.data.find(card => card.card_id === authStore.placeOrderFunnel.order.card_id)

  if (!card) {
    return {}
  }

  return card
})

// Get address name from address_id
const selectedShippingAddress = computed(() => {
  const address = authStore.addresses.data.find(address => address.address_id === authStore.placeOrderFunnel.order.shipping_address_id)

  if (!address) {
    return {}
  }

  return address
})

// Get address name from address_id
const selectedBillingAddress = computed(() => {
  const address = authStore.addresses.data.find(address => address.address_id === authStore.placeOrderFunnel.order.billing_address_id)

  if (!address) {
    return {}
  }

  return address
})

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

.summary-infos {
  display: flex;
  justify-content: start;
  gap: 0.5rem;
  align-items: center;
}

.summary-infos .summary-infos-total {
  font-size: 1.25rem;
  font-weight: bold;
  color: var(--dark);
}

.products-summary {
  margin: 2rem 1.5rem;
}

.products-grid {
  display: grid;
}

.address-grid-title {
  font-size: 1.25rem;
  font-weight: bold;
  color: var(--dark);
  margin-left: 0.5rem;
  margin-bottom: 1rem;
}

.address-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
  gap: 1rem;
  align-items: center;
  margin: 1.5rem;
}

.card-grid {
  display: grid;
  gap: 1rem;
  align-items: center;
  margin: 1.5rem;
}
</style>
