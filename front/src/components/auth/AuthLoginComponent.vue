<template>
  <div class="auth-form">
    <div class="form-group">
      <label class="required" for="email">E-mail</label>
      <input type="text" id="email" placeholder="exemple@new-vet.com" v-model="email" />
    </div>
    <div class="form-group">
      <label class="required" for="password">Mot de passe</label>
      <input type="password" id="password" placeholder="••••••••••••" v-model="password" />
    </div>
    <div class="auth-form-actions">
      <button class="button" @click="handleLogin()">Se connecter</button>
    </div>
  </div>
</template>

<script setup>
import { ref } from "vue";
import { notify } from '@/helpers/notif.js'
import { isValidEmail } from '@/helpers/helpers.js'
import { useAuthStore } from '@/stores/auth'

const authStore = useAuthStore()

const email = ref('');
const password = ref('');

function valid() {
      // return false; // ? uncomment this line to enable form validation
      if (password.value.length < 1) return "Veuillez entrer votre mot de passe";
      if (email.value.length < 1) return "Veuillez entrer votre adresse e-mail";
      if (!isValidEmail(email.value)) return "Veuillez entrer une adresse e-mail valide";
      return false;
}

async function handleLogin() {
      const error = valid();
      if (error) {
        notify(error, 'error');
      } else {
        authStore.login(email.value, password.value)
      }
}
</script>