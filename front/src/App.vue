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
import AuthMain from '@/components/auth/AuthMainComponent.vue'
import Header from '@/components/HeaderComponent.vue'
import Footer from '@/components/FooterComponent.vue'
import { RouterView } from 'vue-router'

</script>
