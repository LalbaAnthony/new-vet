<template>
  <div>
    <AuthMain />
    <Header />
    <main>
      <RouterView />
    </main>
    <Footer />
  </div>
</template>

<script setup>
import { onMounted } from 'vue'
import AuthMain from '@/components/auth/AuthMainComponent.vue'
import Header from '@/components/HeaderComponent.vue'
import Footer from '@/components/FooterComponent.vue'
import { RouterView, useRoute } from 'vue-router'
import { useAuthStore } from '@/stores/auth'

const route = useRoute()
const authStore = useAuthStore()

onMounted(() => {
  if (route.query.email && route.query.token) {
    authStore.verifyEmail(route.query.email, route.query.token)
  }
});

</script>
