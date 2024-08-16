# 📄 - FRONTEND

## Dependances

* vue: `https://vuejs.org/`
* vue-router: `https://router.vuejs.org/`
* pinia: `https://pinia.esm.dev/`
* pinia-plugin-persistedstate: `https://prazdevs.github.io/pinia-plugin-persistedstate/guide/`
* headlessui: `https://headlessui.dev/`
* vue-axios: `https://www.npmjs.com/package/vue-axios`
* axios: `https://axios-http.com/`
* vue-toastification: `https://vue-toastification.maronato.dev/`, `https://blog.logrocket.com/selecting-best-vue-3-toast-notification-library/`
* vue3-carousel: `https://ismail9k.github.io/vue3-carousel/examples.html`

## Structure

* `front/src/assets/` contient les fichiers de styles
* `front/src/components/` contient les composants réutilisables
* `front/src/router/` contient les routes de l'application
* `front/src/stores/` contient les stores de l'application, c'est à dire les variables globales, gérées par Pinia
* `front/src/pages/` contient les pages de l'application
* `front/src/App.vue` est le composant principal de l'application
* `front/src/main.js` est le point d'entrée de l'application
* `front/public/` contient les images et les fichiers statiques, pour des raison de performances, l'extension des images est en `.webp`
* `front/package.json` contient les dépendances du projet

## Configuration

`front/src/config.js` contient les variables de configuration de l'application

Ce fichier est à modifier en fonction de votre configuration

```javascript
export const SITE_NAME = 'NEW VET';
export const COMPANY_NAME = 'NEW VET';

export const FRONT_URL = 'http://localhost:5173/';
export const BACKEND_URL = 'http://localhost/projects/new-vet/back/';
export const BACKEND_API_URL = 'http://localhost/projects/new-vet/back/api/';
export const BACKEND_UPLOAD_URL = 'http://localhost/projects/new-vet/back/uploads/';
```

## Installation

Le partie Front de l'application est conçu en VueJS, pour l'installer, suivez les étapes suivantes:
* Une fois le projet cloné, rendez-vous dans le dossier `front`
* Tapez `npm install` pour mettre à jour les dépéndances
* Rendez vous dans `new-vet/front/src/config.js`, afin de modifier les variables `BACKEND_API_URL` et `BACKEND_UPLOAD_URL` en fonction de votre configuration
* Puis `npm run dev` afin de lancer le projet
* Rendez vous ensuite sur l'adresse indiquez par le terminal, par exemple `http://localhost:5173/`

## Caractéristiques de l'application VueJS

***Store***

Le store de l'application est géré par Pinia, pour plus d'informations, rendez-vous sur `https://pinia.esm.dev/`
Le store `auth` de l'application est persisté par `pinia-plugin-persistedstate`. Et ce pour des raisons de performances, afin de ne pas perdre la session utilisateur lors d'un rafraichissement de la page.

***Routes***

Les routes de l'application sont gérées par VueRouter, pour plus d'informations, rendez-vous sur `https://router.vuejs.org/`

***Composants***

Les composants de l'application sont réutilisables, pour plus d'informations, rendez-vous sur `https://vuejs.org/`

***Pages***

Contrairement à la structure classique de VueJS, ou les pages sont dans le dossier `front/src/views`, ici, les pages sont dans le dossier `front/src/pages`, pour plus de clarté.

***Images***

Pour des raisons de performances, les images en dur sont en `.webp`, pour plus d'informations, rendez-vous sur `https://web.dev/serve-images-webp/`.

***Carousel***

Le carousel de l'application est géré par `vue3-carousel`, pour plus d'informations, rendez-vous sur `https://ismail9k.github.io/vue3-carousel/examples.html`
Le style du carousel est surchargé par le CSS se trouvant dans `front/src/assets/base.css`

***Notifications***

Les notifications de l'application sont gérées par `vue-toastification`, pour plus d'informations, rendez-vous sur `https://vue-toastification.maronato.dev/`, `https://blog.logrocket.com/selecting-best-vue-3-toast-notification-library/`

***Menu***

Le menu de l'application est géré par `headlessui`, pour plus d'informations, rendez-vous sur `https://headlessui.dev/`

***HTTP***

Les requêtes HTTP de l'application sont gérées par `axios`, pour plus d'informations, rendez-vous sur `https://axios-http.com/`, `https://www.npmjs.com/package/vue-axios`