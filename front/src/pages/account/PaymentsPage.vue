<template>
  <div>
    <h2 class="page-title">Mes moyens de paiement</h2>
    <Breadcrumb />
    <AccountLayout />
    <Loader v-if="authStore.cards.loading" />
    <div v-else>
      <div class="card-actions">
        <button class="button" @click="addCardModal = true">Ajouter</button>
      </div>
      <div v-if="authStore.cards.data && authStore.cards.data.length > 0">
        <div class="cards-grid">
          <CreditCard v-for="card in authStore.cards.data" :key="card.card_id" :card="card" />
        </div>
      </div>
      <NoItem v-else />
    </div>

    <!-- Add a Card Modal -->
    <div>
      <div class="darken-background" v-if="addCardModal" @click="addCardModal = false"></div>
      <div class="main-display" v-if="addCardModal">
        <button class="main-display-close" @click="addCardModal = false">
          <IconX />
        </button>

        <h2 class="page-title">Ajouter une carte</h2>

        <div class="auth-form">
          <form>
            <div class="form-split-half">
              <div class="form-group">
                <label for="first_name" class="required">Prénom du titulaire</label>
                <input type="text" id="first_name" v-model="first_name" />
              </div>
              <div class="form-group">
                <label for="last_name" class="required">Nom du titulaire</label>
                <input type="text" id="last_name" v-model="last_name" />
              </div>
            </div>
            <div class="form-group">
              <label for="number" class="required">Numéro de carte</label>
              <input type="text" id="number" placeholder="1234 1234 1234 1234" min="19" max="19" @input="cardNumberOnInput()" v-model="number" />
            </div>
            <div class="form-split-half">
              <div class="form-group">
                <label for="expiration_date" class="required">Date d'expiration</label>
                <input type="text" id="expiration_date" placeholder="01/24" min="5" max="5"  @input="expiryDateOnInput()" v-model="expiration_date" />
              </div>
              <div class="form-group">
                <label for="cvv" class="required">CVV</label>
                <input type="number" id="cvv" placeholder="123" min="3" max="3" v-model="cvv" />
              </div>
            </div>
            <div class="form-actions">
              <button class="button" @click="handleAddCard()">Ajouter</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import Loader from '@/components/LoaderComponent.vue'
import NoItem from '@/components/NoItemComponent.vue'
import Breadcrumb from '@/components/BreadcrumbComponent.vue'
import CreditCard from '@/components/CreditCardComponent.vue'
import AccountLayout from '@/components/account/AccountLayoutComponent.vue'
import { useAuthStore } from '@/stores/auth'
import { notify } from '@/helpers/notif.js'
import IconX from '@/icons/IconX.vue'

const authStore = useAuthStore()

const addCardModal = ref(false)

const first_name = ref('')
const last_name = ref('')
const number = ref('')
const expiration_date = ref('')
const cvv = ref(null)

authStore.fetchCards()

function cardNumberOnInput() {
  number.value = number.value.replace(/\D/g, '')
  if (number.value.length > 16) {
    number.value = number.value.slice(0, 16)
  }
  number.value = number.value.match(/.{1,4}/g).join(' ')
}

function expiryDateOnInput() {
  expiration_date.value = expiration_date.value.replace(/\D/g, '')
  if (expiration_date.value.length > 4) {
    expiration_date.value = expiration_date.value.slice(0, 4)
  }
  expiration_date.value = expiration_date.value.match(/.{1,2}/g).join('/')
}

function valid() {
  // return false; // ? uncomment this line to enable form validation

  first_name.value = first_name.value.trim()
  last_name.value = last_name.value.trim()
  number.value = number.value.trim()
  expiration_date.value = expiration_date.value.trim()

  if (first_name.value.length < 1) return 'Le prénom du titulaire est requis'
  if (last_name.value.length < 1) return 'Le nom du titulaire est requis'
  if (number.value.length < 1) return 'Le numéro de carte est requis'
  if (expiration_date.value.length < 1) return 'La date d\'expiration est requise'
  if (cvv.value.length < 1) return 'Le CVV est requis'

  if (number.value.length < 16) return 'Le numéro de carte est trop court'
  if (cvv.value.length < 3) return 'Le CVV est trop court'

  return false
}

async function handleAddCard() {
  const error = valid()
  if (error) {
    notify(error, 'error')
  } else {

    // Remove spaces from card number
    number.value = number.value.replace(/\s/g, '')

    authStore.addCard({
      first_name: first_name.value,
      last_name: last_name.value,
      number: number.value,
      expiration_date: expiration_date.value,
      cvv: cvv.value
    })
    first_name.value = ''
    last_name.value = ''
    number.value = ''
    expiration_date.value = ''
    cvv.value = null

    authStore.fetchCards()
  }
  addCardModal.value = false
}

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

/* Modal */

.darken-background {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: inherit;
  background-color: rgba(0, 0, 0, 0.75);
  z-index: 999;
}

.main-display {
  background-color: var(--light);
  border-radius: 20px;
  width: 500px;
  max-width: 90%;
  position: fixed;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  box-shadow: 1px 1px 20px 1px rgba(0, 0, 0, 0.1);
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  gap: 1rem;
  padding: 2rem;
  z-index: 1000;
}

button.main-display-close {
  position: absolute;
  top: 1rem;
  right: 1rem;
  color: var(--dark);
  border: none;
  border-radius: 50%;
  padding: 0.5rem;
  cursor: pointer;
}

button.main-display-close>svg {
  width: 20px;
  transform: translate(0, 2px);
}
</style>