<template>
  <footer>
    <div>
      <h5>Réseaux</h5>
      <a href="https://www.facebook.com/NEWVET/" target="_blank">
        <IconFacebook class="social-icon facebook" />
      </a>
      <a href="hhttps://twitter.com/NEWVET" target="_blank">
        <IconTwitterX class="social-icon twitter" />
      </a>
      <a href="https://www.instagram.com/NEWVET/?hl=fr" target="_blank">
        <IconInstagram class="social-icon instagram" />
      </a>
      <a href="https://www.youtube.com/@NEWVET" target="_blank">
        <IconYoutube class="social-icon youtube" />
      </a>
    </div>
    <div>
      <h5>Pages</h5>
      <router-link to="/plan-du-site">
        <span class="link">Plan du site</span>
      </router-link>
      <br>
      <router-link to="/mentions-legales">
        <span class="link">Mentions légales</span>
      </router-link>
      <br>
      <router-link to="/conditions-generales-d-utilisation">
        <span class="link">Conditions générales d'utilisation</span>
      </router-link>
      <br>
      <router-link to="/conditions-generales-de-vente">
        <span class="link">Conditions générales vente</span>
      </router-link>
      <br>
      <router-link to="/contact">
        <span class="link">Contact</span>
      </router-link>
    </div>
    <div>
      <h5>{{ SITE_NAME }}</h5>
      <span>© {{ new Date().getFullYear() }}</span>
    </div>
  </footer>
</template>

<script setup>
import IconFacebook from '@/icons/IconFacebook.vue';
import IconTwitterX from '@/icons/IconTwitterX.vue';
import IconInstagram from '@/icons/IconInstagram.vue';
import IconYoutube from '@/icons/IconYoutube.vue';
import { SITE_NAME } from '@/config';

</script>

<style scoped>
footer {
  color: var(--dark);
  background-color: var(--light);
  box-shadow: 1px 1px 20px 1px rgba(0, 0, 0, 0.1);
  margin-top: 3rem;
  padding: 2rem;
  display: flex;
}

/* DESKTOP */
@media (min-width: 1024px) {
  footer {
    flex-direction: row-reverse;
  }
}

/* TABLET */
@media (min-width: 768px) and (max-width: 1023px) {
  footer {
    flex-direction: row-reverse;
  }
}

/* MOBILE */
@media (max-width: 767px) {
  footer {
    flex-direction: column;
  }
}

footer div {
  margin: 1rem auto;
}

footer h5 {
  font-size: 1rem;
  font-weight: 500;
  margin-bottom: 0.25rem;
}

.social-icon {
  color: var(--primary);
  width: 2rem;
  height: 2rem;
  margin-right: 0.75rem;
  transition: all 0.3s;
}

.social-icon.facebook {
  color: #486CB4 !important;
}

.social-icon.twitter {
  color: #000 !important;
}

.social-icon.instagram {
  color: #E1306C !important;
}

.social-icon.youtube {
  color: #FF0000 !important;
}

.social-icon:hover {
  transform: scale(1.1);
}
</style>