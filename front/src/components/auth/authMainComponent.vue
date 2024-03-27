<template>
  <div>
    <div
      class="darken-background"
      v-if="authStore.authModal.show"
      @click="authStore.toggleModal()"
    ></div>
    <div class="main-display" v-if="authStore.authModal.show">
      <button class="main-display-close" @click="authStore.toggleModal()">
        <IconX />
      </button>

      <h2 class="page-title">{{ allModals[authStore.authModal.type].title }}</h2>

      <component :is="allModals[authStore.authModal.type].component" />

      <div class="password-links">
        <span
          v-if="authStore.authModal.type === 'login' || authStore.authModal.type === 'register'"
          class="local-link"
          @click="authStore.setModal('forgotPassword')"
          >Mot de passe oublié ?</span
        >
        <span
          v-if="authStore.authModal.type === 'forgotPassword'"
          class="local-link"
          @click="authStore.setModal('login')"
          >Retour</span
        >
      </div>

      <TabsActions
        v-if="authStore.authModal.type === 'login' || authStore.authModal.type === 'register'"
        :tabs="[
          {
            title: 'Connexion',
            active: authStore.authModal.type === 'login',
            action: () => {
              authStore.setModal('login')
            }
          },
          {
            title: 'Incription',
            active: authStore.authModal.type === 'register',
            action: () => {
              authStore.setModal('register')
            }
          }
        ]"
      />
    </div>
  </div>
</template>

<script setup>
// eslint-disable-next-line no-unused-vars
import AuthLogin from '@/components/auth/AuthLoginComponent.vue'
// eslint-disable-next-line no-unused-vars
import AuthRegister from '@/components/auth/AuthRegisterComponent.vue'
// eslint-disable-next-line no-unused-vars
import AuthForgotPassword from '@/components/auth/AuthForgotPasswordComponent.vue'
// eslint-disable-next-line no-unused-vars
import AuthResetPassword from '@/components/auth/AuthResetPasswordComponent.vue'
import TabsActions from '@/components/TabsActionsComponent.vue'
import IconX from '@/icons/IconX.vue'
import { ref } from 'vue'
import { useAuthStore } from '@/stores/auth'

const authStore = useAuthStore()

const allModals = ref({
  login: {
    title: 'Connectez-vous',
    component: AuthLogin,
  },
  register: {
    title: 'Inscrivez-vous',
    component: AuthRegister,
  },
  forgotPassword: {
    title: 'Mot de passe oublié',
    component: AuthForgotPassword,
  },
  resetPassword: {
    title: 'Confirmez votre mot de passe',
    component: AuthResetPassword,
  }
})

</script>

<style scoped>
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

button.main-display-close > svg {
  width: 20px;
  height: 20px;
  transform: translate(0, 2px);
}

.password-links {
  display: flex;
  align-items: center;
  justify-content: end;
}

.local-link {
  cursor: pointer;
  font-size: 0.9rem;
  color: var(--dark);
}

.local-link:hover {
  text-decoration: underline;
}
</style>