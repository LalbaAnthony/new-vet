
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
* Lancez XAMPP, rendez-vous `C:/xampp/htdocs/` et créez un dossier `projects`
* Allez `C:/xampp/htdocs/projects` et executez la commande `git git clone git@github.com:LalbaAnthony/new-vet.git`
* Installation du front
    * Allez dans `new-vet/front` 
    * Tapez `npm install` pour mettre à jour les dépéndances
    * Rendez vous dans `new-vet/front/src/config.js`, afin de modifier les variables `URL_BACKEND_API` et `URL_BACKEND_UPLOAD` en fonction de votre configuration
    * Puis `npm run dev` afin de lancer le projet
    * Rendez vous ensuite sur l'adresse indiquez par le terminal, par exemple `http://localhost:5173/`
    * C'est bon, vous avez accès au front !
* Installation de la base de données
    * Rendez-vous sur `http://localhost/phpmyadmin/`
    * Créez une nouvelle base de données nommée `new-vet` en prennat soin de séléctionner `utf8_general_ci` comme jeu de caractères
    * Importez le fichier `back/BDD/structure.sql`
    * Importez le fichier `back/BDD/initial_data.sql`
    * Executez le fichier `back/BDD/users.sql`
    * C'est bon, vous avez accès à la base de données !
* Installation du backend
    * Rendez-vous dans le fichier `config.inc.php` et modifiez les variables `$host`, `$user`, `$password` et `$database` en fonction de votre configuration
    * Toujours dans le même fichier, modifiez les lignes `define('APP_PATH', '/xampp/htdocs/projects/new-vet/back/');` et `define('APP_URL', 'http://localhost/projects/new-vet/back/');` en fonction de votre configuration
    * Rendez-vous sur `http://localhost/projects/new-vet/back/`
    * C'est bon, vous avez accès au back !
  
## 🧱 - Structure du projet

Le projet est divisé en deux parties distinctes, le front et le back.<br>

### 📄 - FRONTEND

Le front (`/front`) est la partie emergée de l'iceberg, c'est la partie visible par l'utilisateur.<br>
Il est conçu en VueJS, le style est entierement custom, écrit à la main par notre artisan intégrateur. Ceci afin de garantir un style unique et personnalisé.<br>

***Dependances***
* vue: `https://vuejs.org/`
* vue-router: `https://router.vuejs.org/`
* pinia: `https://pinia.esm.dev/`
* pinia-plugin-persistedstate: `https://prazdevs.github.io/pinia-plugin-persistedstate/guide/`
* headlessui: `https://headlessui.dev/`
* vue-axios: `https://www.npmjs.com/package/vue-axios`
* axios: `https://axios-http.com/`
* vue-toastification: `https://vue-toastification.maronato.dev/`, `https://blog.logrocket.com/selecting-best-vue-3-toast-notification-library/`
* vue3-carousel: `https://ismail9k.github.io/vue3-carousel/examples.html`

***Structure***

* `front/src/assets/` contient les fichiers de styles
* `front/src/components/` contient les composants réutilisables
* `front/src/router/` contient les routes de l'application
* `front/src/stores/` contient les stores de l'application, c'est à dire les variables globales, gérées par Pinia
* `front/src/pages/` contient les pages de l'application
* `front/src/App.vue` est le composant principal de l'application
* `front/src/main.js` est le point d'entrée de l'application
* `front/public/` contient les images et les fichiers statiques, pour des raison de performances, l'extension des images est en `.webp`
* `front/package.json` contient les dépendances du projet

### 📄 - BACKEND

Le back (`/back`) est elle, la partie immergée, c'est la partie invisible par l'utilisateur.<br>
C'est notamment ici que se trouve la base de données, l'interface API REST, et où se trouve le back-office.<br>
Il est entièrement conçu en PHP natif, et utilise bootstrap pour le style du back-office.<br>

***Structure***

* `back/api/` contient les fichiers de l'API REST, c'est ici que sont gérées les requêtes FRONT
* `back/assets/` contient les images et les fichiers statiques 
* `back/bo/` contient les fichiers du back-office
* `back/database/` contient les fichiers de la base de données: les scripts de création, les scripts d'insertion/suppression de données fictives, et les scripts de création d'utilisateurs
* `back/helpers/` contient les fichiers d'aide, c'est ici que sont gérées les fonctions réutilisables
* `back/logs/` contient les fichiers de logs 
* `back/models/` contient les fichiers de modèles, c'est ici que sont gérées les requêtes SQL
* `back/uplaods/` contient les fichiers uploadés par les administrateurs du site

***REST API***

L'API REST est disponible à l'adresse `http://localhost/projects/new-vet/back/api/`<br>
Les routes sont disponibles dans le fichier `back/api/index.php`<br>

***Base de données***

***Back-office***

Il est possible de créer un nouvel utilisateur en utilisant le formulaire d'inscription.<br>
Il n'est possible de se connecter qu'une fois le compte validé par un administrateur.<br>

## 📦 - Données initials

Le projet est livré avec des données initiales, pour faciliter la prise en main du projet.<br>
Ces données sont disponibles dans le fichier `back/database/initial_data.sql`<br>

## 📝 - Admin (Back-office)

<table>
    <tr>
        <th>Login</th>
        <th>Mot de passe</th>
    </tr>
    <tr>
        <td>testAdmin</td>
        <td>pA0!7MkB73ef</td>
    </tr>
</table>

## 📝 - Clients (Front-office)

<table>
    <tr>
        <th>Prénom</th>
        <th>Nom</th>
        <th>E-mail</th>
        <th>Mot de passe</th>
    </tr>
    <tr>
        <td>Alice</td>
        <td>Dupont</td>
        <td>alice@example.com</td>
        <td>motDeP@sseT3st</td>
    </tr>
    <tr>
        <td>Jean</td>
        <td>Martin</td>
        <td>jean@example.com</td>
        <td>motDeP@sseT3st</td>
    </tr>
    <tr>
        <td>Sophie</td>
        <td>Lefevre</td>
        <td>sophie@example.com</td>
        <td>motDeP@sseT3st</td>
    </tr>
</table>