<template>
  <header>
    <router-link to="/">
      <div class="center">
        <img class="main-logo" src="/logo_clear.webp" alt="Logo de NEW VET">
      </div>
    </router-link>
    <div class="header-actions">
      <input type="search" id="search" name="search" :placeholder="searchPlaceholder" />
      <ul class="toolbar">
        <li>
          <router-link to="/cart">
            <IconCartFill class="toolbar-icon primary" />
          </router-link>
        </li>
        <li>
          <router-link to="/profil">
            <IconPersonFill class="toolbar-icon primary" />
          </router-link>
        </li>
      </ul>
    </div>
    <nav class="header-pages">
      <router-link to="/categories">
        <IconTagFill class="icon-offset" />
        <span>Catégories</span>
      </router-link>
      <router-link to="/produits">
        <IconPersonStandingDress class="icon-offset" />
        <span>Produits</span>
      </router-link>
      <router-link to="/contact">
        <IconEnvelopeFill class="icon-offset" />
        <span>Contact</span>
      </router-link>
    </nav>
    <div class="header-quick-access">
      <Pill v-for="item in quickAccess" :key="item.slug" :text="item.libelle" :link="`/categories/${item.slug}`" type="light" />
    </div>
  </header>
</template>

<script setup>
import { ref } from 'vue'
import Pill from '@/components/Pill.vue'
import IconCartFill from '@/components/icons/IconCartFill.vue'
import IconPersonFill from '@/components/icons/IconPersonFill.vue'
import IconTagFill from '@/components/icons/IconTagFill.vue'
import IconPersonStandingDress from '@/components/icons/IconPersonStandingDress.vue'
import IconEnvelopeFill from '@/components/icons/IconEnvelopeFill.vue'

const searchPlaceholder = ref(randomPlaceholder())
const quickAccess = ref(getQuickAccess())

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

function getQuickAccess() {
  return [
    {
      slug: 'vetements',
      libelle: 'Vêtements',
    },
    {
      slug: 'vetements',
      libelle: 'Vêtements',
    },
    {
      slug: 'vetements',
      libelle: 'Vêtements',
    },
    {
      slug: 'vetements',
      libelle: 'Vêtements',
    }
  ]
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

.center {
  display: flex;
  justify-content: center;
  align-items: center;
}

.main-logo {
  width: 100px;
  height: 100px;
  margin: 0 auto;
}

ul.toolbar {
  display: flex;
  justify-content: space-around;
  align-items: center;
}

ul.toolbar>* {
  margin: 0 0.25rem;
}

.toolbar-icon {
  background-color: var(--light);
  border-radius: 50%;
  color: var(--dark);
  width: 35px;
  height: 35px;
  padding: 0 0.5rem;
  display: flex;
  transition: all 0.3s;
}

.toolbar-icon.primary {
  color: var(--primary);
}

.toolbar-icon.secondary {
  color: var(--secondary);
}

.toolbar-icon:hover {
  transform: scale(1.1);
}

.header-pages {
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

.header-pages>* {
  color: var(--light);
  font-size: 1rem;
  font-weight: 500;
  animation-duration: 0.3s;
  transition: all 0.3s;
}

.header-pages>*:hover {
  transform: translateY(-3px);
}

.header-quick-access {
  display: flex;
  flex-wrap: wrap;
  align-items: center;
  padding: 0.25rem;
  margin: 0 auto;
}
</style>
