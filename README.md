
# 🥼 - NEW VET 

Site E-commerce responsive et dynamique developpé dans la cadre du bachelor SI à Limayrac.
Groupe 1, supervisé par Stéphane Cezera: 
* LALBA Anthony (anthony.lalba@limayrac.fr)
* SIREYJOL Victor (victor.sireyjol@limayrac.fr)

Trello: https://trello.com/b/xVJMjgUN/new-vet

## 🚀 - Quick Start

***Local***

* Installez et configurez XAMPP si ce n'est pas déjà fait, depuis `https://www.apachefriends.org/fr/index.html`
* Lancez XAMPP, rendez-vous `C:/xampp/htdocs/` et créez un dossier `projects`
* Allez `C:/xampp/htdocs/projects` et executez la commande `git git clone git@github.com:LalbaAnthony/new-vet.git`
* Installation du front
    * Allez dans `new-vet/front` 
    * Tapez `npm install` pour mettre à jour les dépéndances
    * Rendez vous dans `new-vet/front/src/config.js`, afin de modifier les variables `BACKEND_API_URL` et `BACKEND_UPLOAD_URL` en fonction de votre configuration
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
    * Accordez les droits d'écriture sur le dossier `uploads` et `logs`: `cd /new-vet/back && sudo chown -R www-data logs uploads`
    * Toujours dans le même fichier, modifiez les lignes `define('APP_PATH', '/xampp/htdocs/projects/new-vet/back/');` et `define('APP_URL', 'http://localhost/projects/new-vet/back/');` en fonction de votre configuration
    * Rendez-vous sur `http://localhost/projects/new-vet/back/`
    * C'est bon, vous avez accès au back !
  
## 🧱 - Structure du projet

Le projet est divisé en deux parties distinctes, le front et le back.

### 📄 - FRONTEND

Le front (`/front`) est la partie emergée de l'iceberg, c'est la partie visible par l'utilisateur.
Il est conçu en VueJS, le style est entierement custom, écrit à la main par notre artisan intégrateur. Ceci afin de garantir un style unique et personnalisé.

Vous trouverez toutes les informations relatives au front dans le fichier `front/README.md`

### 📄 - BACKEND

Le back (`/back`) est elle, la partie immergée, c'est la partie invisible par l'utilisateur.
C'est notamment ici que se trouve la base de données, l'interface API REST, et où se trouve le back-office.
Il est entièrement conçu en PHP natif, et utilise bootstrap pour le style du back-office.

Vous trouverez toutes les informations relatives au back dans le fichier `back/README.md`

## 📦 - Données initials

Le projet est livré avec des données initiales, pour faciliter la prise en main du projet.
Ces données sont disponibles dans le fichier `back/database/initial_data.sql`

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