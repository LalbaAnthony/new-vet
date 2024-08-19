<template>
  <div>
    <h2 class="page-title">Mes adresses</h2>
    <Breadcrumb />
    <AccountLayout />
    <Loader v-if="authStore.addresses.loading" />
    <div v-else>
      <div class="address-actions">
        <button class="button" @click="addAddressModal = true">Ajouter</button>
      </div>
      <div v-if="authStore.addresses.data && authStore.addresses.data.length > 0">
        <div class="addresses-grid">
          <Adress v-for="address in authStore.addresses.data" :key="address.address_id" :address="address" />
        </div>
      </div>
      <NoItem v-else />
    </div>

    <!-- Add a Address Modal -->
    <div>
      <div class="darken-background" v-if="addAddressModal" @click="addAddressModal = false"></div>
      <div class="main-display" v-if="addAddressModal">
        <button class="main-display-close" @click="addAddressModal = false">
          <IconX />
        </button>

        <h2 class="page-title">Ajouter une adresse</h2>

        <div class="auth-form">
          <form>
            <div class="form-split-half">
              <div class="form-group">
                <label for="first_name" class="required">Prénom</label>
                <input type="text" id="first_name" v-model="first_name" />
              </div>
              <div class="form-group">
                <label for="last_name" class="required">Nom</label>
                <input type="text" id="last_name" v-model="last_name" />
              </div>
            </div>
            <div class="form-group">
              <label for="tel" class="required">Tél.</label>
              <input type="text" id="tel" v-model="tel" />
            </div>
            <div class="form-split-half">
              <div class="form-group">
                <label for="region" class="required">Région</label>
                <input type="text" id="region" v-model="region" />
              </div>
              <div class="form-group">
                <label for="country_id" class="required">Pays</label>
                <select v-if="countryStore.countries.data.length > 0" v-model="country_id" id="country_id">
                  <option v-for="country in countryStore.countries.data" :key="country.country_id"
                    :value="country.country_id">{{ country.name }}</option>
                </select>
              </div>
            </div>
            <div class="form-group">
              <label for="address1" class="required">Adresse 1</label>
              <input type="text" id="address1" v-model="address1" />
            </div>
            <div class="form-group">
              <label for="address2">Adresse 2</label>
              <input type="text" id="address2" v-model="address2" />
            </div>
            <div class="form-split-half">
              <div class="form-group">
                <label for="city" class="required">Ville</label>
                <input type="text" id="city" v-model="city" />
              </div>
              <div class="form-group">
                <label for="zip" class="required">Code postal</label>
                <input type="number" id="zip" min="6" max="6" v-model="zip" />
              </div>
            </div>
            <div class="form-actions">
              <button class="button" @click="handleAddAddress()">Ajouter</button>
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
import Adress from '@/components/AdressComponent.vue'
import AccountLayout from '@/components/account/AccountLayoutComponent.vue'
import { useAuthStore } from '@/stores/auth'
import { useCountryStore } from '@/stores/country'
import { notify } from '@/helpers/notif.js'
import IconX from '@/icons/IconX.vue'

const authStore = useAuthStore()
const countryStore = useCountryStore()

const addAddressModal = ref(false)

const first_name = ref('')
const last_name = ref('')
const address1 = ref('')
const address2 = ref('')
const city = ref('')
const region = ref('')
const zip = ref(null)
const country_id = ref(null)
const tel = ref('')

authStore.fetchAddresses()
countryStore.fetchCountries()

function valid() {
  // return false; // ? uncomment this line to enable form validation

  first_name.value = first_name.value.trim()
  last_name.value = last_name.value.trim()
  address1.value = address1.value.trim()
  address2.value = address2.value.trim()
  city.value = city.value.trim()
  region.value = region.value.trim()
  tel.value = tel.value.trim()

  if (first_name.value.length < 1) return 'Le prénom du titulaire est requis'
  if (last_name.value.length < 1) return 'Le nom du titulaire est requis'
  if (address1.value.length < 1) return 'Le numéro de adresse est requis'
  if (city.value.length < 1) return 'Le CVV est requis'
  if (region.value.length < 1) return 'Le CVV est requis'
  if (zip.value.length < 1) return 'Le CVV est requis'
  if (country_id.value.length < 1) return 'Le CVV est requis'
  if (tel.value.length < 1) return 'Le CVV est requis'

  return false
}

async function handleAddAddress() {
  const error = valid()
  if (error) {
    notify(error, 'error')
  } else {

    authStore.addAddress({
      first_name: first_name.value,
      last_name: last_name.value,
      address1: address1.value,
      address2: address2.value,
      city: city.value,
      region: region.value,
      zip: zip.value,
      country_id: country_id.value,
      tel: tel.value,
    })
    first_name.value = ''
    last_name.value = ''
    address1.value = ''
    address2.value = ''
    city.value = ''
    region.value = ''
    zip.value = null
    country_id.value = null
    tel.value = ''

    authStore.fetchAddresses()
  }
  addAddressModal.value = false
}

</script>

<style scoped>
.addresses-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
  gap: 20px;
}

.address-actions {
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