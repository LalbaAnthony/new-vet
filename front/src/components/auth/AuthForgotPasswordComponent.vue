<template>
  <div class="auth-form">
    <div class="form-group my-4">
      <label class="required" for="email">E-mail</label>
      <input type="text" id="email" v-model="authStore.fogotPasswordEmail" />
    </div>
    <div class="form-actions">
      <button class="button" @click="handleForgotPassword()">Envoyer le code</button>
    </div>
  </div>
</template>

<script setup>
import { notify } from '@/helpers/notif.js'
import { isValidEmail } from '@/helpers/helpers.js'
import { useAuthStore } from '@/stores/auth'

const authStore = useAuthStore()

function valid() {
  // return false; // ? uncomment this line to enable form validation
  
  authStore.fogotPasswordEmail = authStore.fogotPasswordEmail.trim()

  if (authStore.fogotPasswordEmail.length < 1) return 'Veuillez entrer votre adresse e-mail'
  if (!isValidEmail(authStore.fogotPasswordEmail))
    return 'Veuillez entrer une adresse e-mail valide'
  return false
}

async function handleForgotPassword() {
  const error = valid()
  if (error) {
    notify(error, 'error')
  } else {
    authStore.forgotPassword(authStore.fogotPasswordEmail)
    authStore.setModal('resetPassword')
  }
}
</script>