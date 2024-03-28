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
    <div class="auth-form-actions">
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
import { get } from '@/helpers/api'

const authStore = useAuthStore()

const first_name = ref('')
const last_name = ref('')
const email = ref('')
const password = ref('')
const confirmPassword = ref('')

function valid() {
  // return false; // ? uncomment this line to enable form validation
  if (password.value.length < 1) return 'Veuillez entrer votre mot de passe'
  if (email.value.length < 1) return 'Veuillez entrer votre adresse e-mail'
  if (!isValidEmail(email.value)) return 'Veuillez entrer une adresse e-mail valide'
  return false
}

async function handleRegister() {
  const error = valid()
  if (error) {
    notify(error, 'error')
  } else {
    authStore.login(email.value, password.value)
  }
}
</script>