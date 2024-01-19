<template>
  <div>
    <Header />
    <main>
      <RouterView />
    </main>
    <Footer />
  </div>
</template>

<script setup>
import Header from '@/components/HeaderComponent.vue'
import Footer from '@/components/FooterComponent.vue'
import { RouterView } from 'vue-router'

</script>
