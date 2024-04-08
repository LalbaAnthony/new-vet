<template>
  <div class="auth-form">
    <div class="form-group">
      <label class="required" for="code">Code (réçu par e-mail)</label>
      <input type="text" id="code" v-model="code" />
    </div>
    <div class="form-group">
      <label class="required" for="password">Nouveau mot de passe</label>
      <input type="password" id="password" v-model="password" />
    </div>
    <div class="form-group">
      <label class="required" for="password">Confirmez votre mot de passe</label>
      <input type="password" id="confirmPassword" v-model="confirmPassword" />
    </div>
    <PasswordStrength :password="password || confirmPassword" />

    <div class="form-actions">
      <button class="button" @click="handleRegister()">Envoyer</button>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { notify } from '@/helpers/notif.js'
import PasswordStrength from '@/components/PasswordStrengthComponent.vue'
import { missingElementsPassword } from '@/helpers/helpers.js'
import { useAuthStore } from '@/stores/auth'

const authStore = useAuthStore()

const code = ref(null)
const password = ref('')
const confirmPassword = ref('')

function valid() {
  // return false; // ? uncomment this line to enable form validation
  if (!code.value) return 'Veuillez entrer le code reçu par e-mail'
  if (password.value.length < 1) return 'Veuillez entrer votre mot de passe'
  if (password.value !== confirmPassword.value) return 'Les mots de passe ne correspondent pas'
  if (missingElementsPassword(password.value).length > 0) return `Le mot de passe doit contenir au moins: ${missingElementsPassword(password.value).join(', ')}`
  return false
}

async function handleRegister() {
  const error = valid()
  if (error) {
    notify(error, 'error')
  } else {
    authStore.resetPassword(code.value, password.value)
    code.value = ''
    password.value = ''
    confirmPassword.value = ''
  }
}
</script>