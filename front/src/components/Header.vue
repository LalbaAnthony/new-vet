<template>
  <header>
    <router-link to="/">
      <h1 class="site-title">NEW VET</h1>
    </router-link>
    <div class="header-actions">
      <input type="search" id="search" name="search" :placeholder="searchPlaceholder" />
      <ul class="toolbar">
        <li>
          <router-link to="/cart">
            <IconCartFill class="toolbar-icon" />
          </router-link>
        </li>
        <li>
          <router-link to="/profil">
            <IconPersonFill class="toolbar-icon" />
          </router-link>
        </li>
      </ul>
    </div>
    <nav>
      <router-link to="/categories">
        <IconTagFill class="icon-offset" />
        <span>Catégories</span>
      </router-link>
      <router-link to="/products">
        <IconPersonStandingDress class="icon-offset" />
        <span>Produits</span>
      </router-link>
      <router-link to="/contact">
        <IconEnvelopeFill class="icon-offset" />
        <span>Contact</span>
      </router-link>
    </nav>
  </header>
</template>

<script setup>
import { ref } from 'vue'
import IconCartFill from '@/components/icons/IconCartFill.vue'
import IconPersonFill from '@/components/icons/IconPersonFill.vue'
import IconTagFill from '@/components/icons/IconTagFill.vue'
import IconPersonStandingDress from '@/components/icons/IconPersonStandingDress.vue'
import IconEnvelopeFill from '@/components/icons/IconEnvelopeFill.vue'

const searchPlaceholder = ref(randomPlaceholder())

function randomPlaceholder() {
  const placeholders = [
    'Rechercher ...',
    'Chercher un produit ...',
    'Chercher un article ...',
    'Rechercher un produit ...',
    'Rechercher un article ...',
    'Trouver un produit ...',
    'Trouver un article ...'
  ]
  return placeholders[Math.floor(Math.random() * placeholders.length)]
}

</script>

<style scoped>
/* DESKTOP */
@media (min-width: 1024px) {
  .header-actions>* {
    margin: 0 1rem;
  }
}

/* TABLET */
@media (min-width: 768px) and (max-width: 1023px) {
  .header-actions>* {
    margin: 0 0.5rem;
  }
}

/* MOBILE */
@media (max-width: 767px) {
  .header-actions>* {
    margin: 0 0.2rem;
  }
}

header {
  background: var(--secondary);
  background: linear-gradient(90deg, var(--secondary) 0%, var(--primary) 100%);
  color: var(--light);
  display: flex;
  flex-direction: column;
}

.header-actions {
  display: flex;
  justify-content: space-between;
  align-items: center;
}

h1.site-title {
  color: var(--light);
  font-size: 2rem;
  margin: 0;
  padding: 1rem;
  text-align: center;
}

.toolbar {
  display: flex;
  justify-content: space-around;
  align-items: center;
}

.toolbar-icon {
  color: var(--light);
  width: 50px;
  height: 50px;
  padding: 0 0.5rem;
  transition: all 0.3s;
}

.toolbar-icon:hover {
  transform: scale(1.1);
}

nav {
  display: flex;
  justify-content: space-around;
  align-items: center;
  padding: 0.5rem;
  animation-name: fromBottom;
  animation-duration: 0.5s;
  max-width: 100%;
  width: 500px;
  margin: 0 auto;
}

@keyframes fromBottom {
  from {
    opacity: 0;
    transform: translateY(15px);
  }

  to {
    opacity: 1;
    transform: translateY(0);
  }
}

nav>* {
  color: var(--light);
  font-size: 1rem;
  font-weight: 500;
  animation-duration: 0.3s;
  transition: all 0.3s;
}

nav>*:hover {
  transform: translateY(-3px);
}
</style>
