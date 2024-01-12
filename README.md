
# 🥼 - NEW VET 

Site E-commerce responsive et dynamique developpé dans la cadre du bachelor SI à Limayrac.<br>
Groupe 1, supervisé par Stéphane Cezera: 
* LALBA Anthony (anthony.lalba@limayrac.fr)
* SIREYJOL Victor (victor.sireyjol@limayrac.fr)
<br>
Trello: https://trello.com/b/xVJMjgUN/new-vet<br>

## 🚀 - Quick Start

***Local***

* Installez et configurez XAMPP si ce n'est pas déjà fait, depuis `https://www.apachefriends.org/fr/index.html`
* LAncez XAMPP, rendez-vous `C:\xampp\htdocs\` et créez un dossier `projects`
* Allez `C:\xampp\htdocs\projects` et executez la commande `git git clone git@github.com:LalbaAnthony/new-vet.git`
* Installation du front
    * Allez dans `C:\xampp\htdocs\projects\new-vet\front` 
    * Tapez `npm install` pour mettre à jour les dépéndances
    * Puis `npm run dev` afin de lancer le projet
    * Rendez vous ensuite sur l'adresse indiquez par le terminal, par exemple `http://localhost:5173/`
    * C'est bon, vous avez accès au front !
* Installation de la base de données
    * Rendez-vous sur `http://localhost/phpmyadmin/`
    * Créez une nouvelle base de données nommée `new-vet` en prennat soin de séléctionner `utf8_general_ci` comme jeu de caractères
    * Importez le fichier `back\BDD\structure.sql`
    * Importez le fichier `back\BDD\initial_data.sql`
    * Executez le fichier `back\BDD\users.sql`
    * C'est bon, vous avez accès à la base de données !

## 🧱 - Structure du projet

Le projet est divisé en deux parties distinctes, le front et le back.<br>

### 📄 - FRONTEND

Le front (`/front`) est la partie emergée de l'iceberg, c'est la partie visible par l'utilisateur.<br>
Il est conçu en VueJS, le style est entierement custom, écrit à la main par notre artisan intégrateur. Ceci afin de garantir un style unique et personnalisé.<br>

***Dependances***
* vue: https://vuejs.org/
* vue-router: https://router.vuejs.org/
* pinia: https://pinia.esm.dev/
* headlessui: https://headlessui.dev/
* vue-axios: https://www.npmjs.com/package/vue-axios
* axios: https://axios-http.com/
* vue-toastification: https://vue-toastification.maronato.dev/

***Structure***

* `front/src/assets` contient les fichiers de styles
* `front/src/components` contient les composants réutilisables
* `front/src/router` contient les routes de l'application
* `front/src/stores` contient les stores de l'application, c'est à dire les variables globales, gérées par Pinia
* `front/src/pages` contient les pages de l'application
* `front/src/App.vue` est le composant principal de l'application
* `front/src/main.js` est le point d'entrée de l'application
* `front/package.json` contient les dépendances du projet

### 📄 - BACKEND

Le back (`/back`) est elle, la partie immergée, c'est la partie invisible par l'utilisateur.<br>
C'est notamment ici que se trouve la base de données, l'interface API REST, et où se trouve le back-office.<br>
Il est entièrement conçu en PHP natif, et utilise bootstrap pour le style du back-office.<br>

***REST API***

***Base de données***

***Back-office***