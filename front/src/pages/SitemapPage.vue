<template>
  <div class="large-min-height">
    <h2 class="page-title">Plan du site</h2>
    <Breadcrumb />
    <section>
      <ul class="fancy-list">
        <li><a href="/" class="dark">Accueil</a></li>
        <li><a href="/se-connecter" class="dark">Se connecter</a></li>
        <li><a href="/mon-compte" class="dark">Mon compte</a></li>
        <li><a href="/mes-commandes" class="dark">Mes commandes</a></li>
        <li><a href="/categories" class="dark">Catégories</a></li>
        <li><a href="/produits" class="dark">Produits</a></li>
        <li><a href="/panier" class="dark">Panier</a></li>
        <li><a href="/contact" class="dark">Contact</a></li>
        <li><a href="/plan-du-site" class="dark">Plan du site</a></li>
        <li><a href="/mentions-legales" class="dark">Mentions légales</a></li>
        <li><a to="/conditions-generales-d-utilisation" class="dark">Conditions générales d'utilisation</a></li>
      </ul>
    </section>
  </div>
</template>

<script setup>
import Breadcrumb from '@/components/BreadcrumbComponent.vue'
</script>

<style scoped>
.large-min-height {
  min-height: 50vh;
}
</style>
