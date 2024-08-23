<template>
  <div>
    <h2 class="page-title">Mes identifiants et mot de passes</h2>
    <Breadcrumb />
    <AccountLayout />

    <div class="id-infos">
      <span>Numéro d'utilisateur: {{ authStore?.user?.customer_id }}</span>
    </div>

    <section class="section others">
      <div class="has-validated-email">
        <span>Adresse e-mail validé ?:</span>
        <div :class="[authStore.user.has_validated_email ? 'success' : 'danger', 'badge']">
          {{ authStore.user.has_validated_email ? 'Oui' : 'Non' }}
        </div>
      </div>
    </section>

    <section class="section password">
      <div class="password-grid">
        <div class="form-group my-4">
          <label for="current-password" class="required">Mot de passe actuel</label>
          <input type="password" id="current-password" v-model="currentPassword" />
        </div>

        <div class="form-group my-4">
          <label for="password" class="required">Nouveau mot de passe</label>
          <input type="password" id="password" v-model="password" />
        </div>

        <div class="form-group my-4">
          <label for="confirm-password" class="required"
            >Confirmez votre nouveau mot de passe</label
          >
          <input type="password" id="confirm-password" v-model="confirmPassword" />
        </div>
      </div>

      <PasswordStrength :password="password || confirmPassword" />

      <div class="password-actions">
        <button class="button" @click="changePassword()">Changer le mot de passe</button>
      </div>
    </section>

    <section class="section dates">
      <span
        ><b>Création du compte:</b> {{ datetimeToNiceDatetime(authStore.user.created_at) }}</span
      >
      <span
        ><b>Dernière connexion:</b> {{ datetimeToNiceDatetime(authStore.user.last_login) }}</span
      >
    </section>

    <div class="actions">
      <button @click="authStore.logout()" class="button danger">Se déconnecter</button>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import Breadcrumb from '@/components/BreadcrumbComponent.vue'
import AccountLayout from '@/components/account/AccountLayoutComponent.vue'
import PasswordStrength from '@/components/PasswordStrengthComponent.vue'
import { useAuthStore } from '@/stores/auth'
import { datetimeToNiceDatetime } from '@/helpers/helpers.js'
import { missingElementsPassword } from '@/helpers/helpers.js'
import { notify } from '@/helpers/notif.js'

const authStore = useAuthStore()

const password = ref('')
const currentPassword = ref('')
const confirmPassword = ref('')

authStore.getUserInfos()

function valid() {
  // return false; // ? uncomment this line to enable form validation
  if (currentPassword.value.length < 1) return 'Veuillez entrer votre mot de passe actuel'
  if (password.value.length < 1) return 'Veuillez entrer votre nouveau mot de passe'
  if (confirmPassword.value.length < 1) return 'Veuillez entrer la confirmation de votre nouveau mot de passe'
  if (missingElementsPassword(password.value).length > 0) return `Le nouveau mot de passe doit contenir au moins: ${missingElementsPassword(password.value).join(', ')}`
  if (password.value !== confirmPassword.value) return 'Les mots de passe ne correspondent pas'
  if (currentPassword.value === password.value) return 'Le nouveau mot de passe doit être différent de l\'ancien'
  return false
}

async function changePassword() {
  const error = valid()
  if (error) {
    notify(error, 'error')
  } else {
    authStore.changePassword(currentPassword.value, password.value)
    currentPassword.value = ''
    password.value = ''
    confirmPassword.value = ''
    authStore.logout()
  }
}
</script>

<style scoped>
.id-infos {
  margin: 2rem 0;
  font-size: 1rem;
  color: var(--gray);
}

section.section {
  margin: 1rem 0;
  padding: 1rem;
  border-radius: 15px;
  background-color: var(--light-gray);
}

.dates,
.others,
.password {
  display: flex;
  flex-direction: column;
  gap: 0.5rem;
}

.password {
  gap: 1.5rem !important;
}

.password-grid {
  display: grid;
  gap: 1.5rem;
  grid-template-columns: repeat(auto-fit, minmax(min(15rem, 100%), 1fr));
  /* max-width: px; */
}

.password-actions {
  display: flex;
  justify-content: center;
  align-items: center;
}

.has-validated-email {
  display: flex;
  justify-content: start;
  align-items: center;
  gap: 1rem;
}

.actions {
  margin: 2rem 0;
  display: flex;
  justify-content: end;
  align-items: center;
  gap: 1rem;
}
</style>