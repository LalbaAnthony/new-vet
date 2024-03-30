<template>
  <div class="auth-form">
    <div class="form-split-half">
      <div class="form-group">
        <label class="required" for="first_name">Prénom</label>
        <input type="text" id="first_name" v-model="first_name" />
      </div>
      <div class="form-group">
        <label class="required" for="last_name">Nom</label>
        <input type="text" id="last_name" v-model="last_name" />
      </div>
    </div>

    <div class="form-group">
      <label class="required" for="email">E-mail</label>
      <input type="text" id="email" v-model="email" />
    </div>
    <div class="form-group">
      <label class="required" for="password">Mot de passe</label>
      <input type="password" id="password" v-model="password" />
    </div>
    <div class="form-group">
      <label class="required" for="password">Confirmez votre mot de passe</label>
      <input type="password" id="confirmPassword" v-model="confirmPassword" />
    </div>
    <PasswordStrength :password="password || confirmPassword" />
    <div class="checkbox-group">
      <input type="checkbox" id="collect_data" name="collect_data" v-model="collect_data" />
      <label for="collect_data"
        >En cochant cette case, j'accepte que mes données soient collectées et exploitées par NEW
        VET. Pour plus d'informations, consultez nos
        <router-link to="/mentions-legales" class="link">mentions légales</router-link>.</label
      >
    </div>
    <div class="form-actions">
      <button class="button" @click="handleRegister()">S'inscrire</button>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { notify } from '@/helpers/notif.js'
import PasswordStrength from '@/components/PasswordStrengthComponent.vue'
import { isValidEmail } from '@/helpers/helpers.js'
import { useAuthStore } from '@/stores/auth'

const authStore = useAuthStore()

const first_name = ref('')
const last_name = ref('')
const email = ref('')
const password = ref('')
const confirmPassword = ref('')
const collect_data = ref(false)

function valid() {
  // return false; // ? uncomment this line to enable form validation
  if (password.value.length < 1) return 'Veuillez entrer votre mot de passe'
  if (email.value.length < 1) return 'Veuillez entrer votre adresse e-mail'
  if (!isValidEmail(email.value)) return 'Veuillez entrer une adresse e-mail valide'
  if (password.value !== confirmPassword.value) return 'Les mots de passe ne correspondent pas'
  if (!collect_data.value) return 'Veuillez accepter la collecte de données'
  return false
}

async function handleRegister() {
  const error = valid()
  if (error) {
    notify(error, 'error')
  } else {
    authStore.register({
      first_name: first_name.value,
      last_name: last_name.value,
      email: email.value,
      password: password.value,
      collect_data: collect_data.value
    })
  }
}
</script>