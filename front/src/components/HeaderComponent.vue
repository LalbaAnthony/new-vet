<template>
  <header>
    <div class="header-bloc">
      <router-link to="/">
        <div class="bloc-logo">
          <img class="main-logo" src="/logo_clear.webp" alt="Logo de NEW VET">
        </div>
      </router-link>
      <div class="header-actions">
        <input type="search" class="search" id="search" name="search" :placeholder="searchPlaceholder" v-model="search"
          @keyup.enter="triggerSearch" />
        <ul class="header-action-btn">
          <li>
            <span v-if="authStore.cart" class="cart-number">{{ authStore.cartSize }}</span>
            <router-link to="/panier">
              <IconCartFill class="header-action-btn-icon primary" />
            </router-link>
          </li>
          <li>
            <router-link to="/profil">
              <IconPersonFill class="header-action-btn-icon primary" />
            </router-link>
          </li>
        </ul>
      </div>
    </div>
    <nav class="header-pages">
      <router-link to="/">
        <IconHouseFill class="icon-offset" />
        <span>Accueil</span>
      </router-link>
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
    <div v-if="categoryStore.quickAccessCategories.data" class="header-categories">
      <div class="header-quick-access">
        <Pill v-for="item in categoryStore.quickAccessCategories.data" :key="item.slug" :text="item.libelle"
          :link="`/categories/${item.slug}`" type="light" />
      </div>
    </div>
  </header>
</template>

<script setup>
import { ref } from 'vue'
import Pill from '@/components/PillComponent.vue'
import IconCartFill from '@/components/icons/IconCartFill.vue'
import IconPersonFill from '@/components/icons/IconPersonFill.vue'
import IconHouseFill from '@/components/icons/IconHouseFill.vue'
import IconTagFill from '@/components/icons/IconTagFill.vue'
import IconPersonStandingDress from '@/components/icons/IconPersonStandingDress.vue'
import IconEnvelopeFill from '@/components/icons/IconEnvelopeFill.vue'
import { useAuthStore } from '@/stores/auth'
import router from '@/router';
import { randSearchPlaceholder } from '@/helpers/helpers.js'
import { useCategoryStore } from '@/stores/category'

const authStore = useAuthStore()
const categoryStore = useCategoryStore()

const searchPlaceholder = ref(randSearchPlaceholder())
const search = ref('')

categoryStore.fetchQuickAccessCategories();

function triggerSearch() {
  router.push(`/recherche/${search.value}`)
  search.value = ''
}

</script>

<style scoped>
/* DESKTOP */
@media (min-width: 1024px) {
  .header-bloc {
    display: flex;
    max-width: 900px;
    margin: 0 auto;
    flex-direction: row;
  }
}

/* TABLET */
@media (min-width: 768px) and (max-width: 1023px) {
  .header-bloc {
    display: flex;
    flex-direction: row;
  }
}

/* MOBILE */
@media (max-width: 767px) {
  .header-bloc {
    display: flex;
    flex-direction: column;
  }
}

header {
  background: var(--secondary);
  background: linear-gradient(90deg, var(--secondary) 0%, var(--primary) 100%);
  color: var(--light);
}

.bloc-logo,
.header-categories {
  display: flex;
  justify-content: center;
  align-items: center;
}

.header-actions {
  display: flex;
  justify-content: space-between;
  align-items: center;
  width: 100%;
  padding: 0 0.5rem;
}

.main-logo {
  width: 100px;
  height: 100px;
  margin: 0 auto;
}

ul.header-action-btn {
  display: flex;
  justify-content: space-around;
  align-items: center;
  padding: auto;
}

ul.header-action-btn>* {
  margin: 0 0.25rem;
}

.header-action-btn-icon {
  background-color: var(--light);
  border-radius: 50%;
  color: var(--dark);
  width: 35px;
  height: 35px;
  padding: 0 0.5rem;
  display: flex;
  transition: all 0.3s;
}

.header-action-btn-icon.primary {
  color: var(--primary);
}

.header-action-btn-icon.secondary {
  color: var(--secondary);
}

.header-action-btn-icon:hover {
  transform: scale(1.1);
}

.cart-number {
  z-index: 1;
  position: absolute;
  padding: 0 8px;
  background-color: var(--secondary);
  color: var(--light);
  border-radius: 50%;
  transform: translate(80%, -50%);
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
  justify-content: start;
  display: flex;
  flex-wrap: wrap;
  align-items: center;
  padding: 0.25rem;
  margin: 0 auto;
}
</style>