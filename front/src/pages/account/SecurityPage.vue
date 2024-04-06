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
        <div class="form-group">
          <label for="password">Mot de passe actuel</label>
          <input type="password" id="password" v-model="password" />
        </div>

        <div class="form-group">
          <label for="current-password">Nouveau mot de passe</label>
          <input type="password" id="current-password" v-model="currentPassword" />
        </div>
      </div>

      <div class="password-actions">
        <button class="button">Changer le mot de passe</button>
      </div>
    </section>

    <section class="section dates">
      <span
        ><b>Dernière connexion:</b> {{ datetimeToNiceDatetime(authStore.user.last_login) }}</span
      >
      <span
        ><b>Création du compte:</b> {{ datetimeToNiceDatetime(authStore.user.created_at) }}</span
      >
    </section>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import Breadcrumb from '@/components/BreadcrumbComponent.vue'
import AccountLayout from '@/components/account/AccountLayoutComponent.vue'
import { useAuthStore } from '@/stores/auth'
import { datetimeToNiceDatetime } from '@/helpers/helpers.js'

const authStore = useAuthStore()

const password = ref('')
const currentPassword = ref('')
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
  background-color: #f9f9f9;
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
  grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
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
  gap: 0.5rem;
}
</style>