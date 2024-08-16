# 📄 - BACKEND

Le back (`/back`) est elle, la partie immergée, c'est la partie invisible par l'utilisateur.
C'est notamment ici que se trouve la base de données, l'interface API REST, et où se trouve le back-office.
Il est entièrement conçu en PHP natif, et utilise bootstrap pour le style du back-office.

## Structure

* `back/api/` contient les fichiers de l'API REST, c'est ici que sont gérées les requêtes FRONT
* `back/assets/` contient les images et les fichiers statiques 
* `back/bo/` contient les fichiers du back-office
* `back/controllers/` contient les fichiers de controllers, c'est ici que sont gérées les requêtes SQL
* `back/crons/` contient les fichiers de cron, c'est ici que sont gérées les tâches planifiées
* `back/database/` contient les fichiers de la base de données: les scripts de création, les scripts d'insertion/suppression de données fictives, et les scripts de création d'utilisateurs
* `back/emails/` contient les mails envoyés par l'application, lorsque celle ci est configurée avec `define('EMAIL_FAKE', true);`
* `back/helpers/` contient les fonction utilitaires, c'est ici que sont gérées les fonctions réutilisables
* `back/logs/` contient les fichiers de logs 
* `back/tests/` contient les fichiers de tests unitaires
* `back/uploads/` contient les fichiers uploadés par les administrateurs du site
* `back/utils/` contient les classes utilitaires, c'est ici que sont gérées les classes réutilisables comme la classe de connexion à la base de données 

## Configuration

`back/config.php` contient les variables de configuration de l'applicationet de base de données et les constantes de l'application

Ce fichier est à modifier en fonction de votre configuration

```php
define('SITE_NAME', 'NEW VET');
define('COMPANY_NAME', 'NEW VET');

// ...
```

Ce fichier se charge aussi d'importer les scripts et les classes nécessaires à l'application

## REST API

L'API REST est disponible à l'adresse `http://localhost/projects/new-vet/back/api/`
Les routes sont disponibles dans le fichier `back/api/index.php`

```php
include_once APP_PATH . 'utils/database.php';
include_once APP_PATH . 'helpers/log_txt.php';
include_once APP_PATH . 'helpers/dd.php';
include_once APP_PATH . 'helpers/print_post_dump.php';
include_once APP_PATH . 'helpers/image_or_placeholder.php';
```

## Assets

`back/assets/` contient les images et les fichiers statiques de l'application.
Il contient notament les favicons, etc.

## Back-office

Le back-office est disponible à l'adresse `http://localhost/projects/new-vet/back/back-office/index.php`

Les fichiers du back-office sont dans le dossier `back/bo/`

Ce dossier contient les fichiers :
* de style : `back/bo/style/`
* de scripts JS : `back/bo/scripts/`
* de pages : `back/bo/pages/`
* de composants : `back/bo/parials/`

### Comtpte administrateur

Il est necessaire de se connecter pour accéder au back-office, et ceci avec un compte administrateur.

Il est possible de créer un nouvel utilisateur en utilisant le formulaire d'inscription.
Il n'est possible de se connecter qu'une fois le compte validé par un administrateur.

## Controlleurs

Les controlleurs sont les fichiers qui gèrent les requêtes SQL.
Ils sont à la fois appelés par les fichiers de l'API REST, et par les fichiers du back-office.

## CRONS

Un CRON est une tâche planifiée, c'est à dire une tâche qui s'exécute à une heure précise, sous Linux.
Les fichiers de CRON sont dans le dossier `back/crons/`

## Base de données

La base de données est réalisée en MySQL, 

Les scripts sont dans le dossier `back/database/` :
- `back/database/structure.sql` : Les tables
- `back/database/initial_data.sql` : Les données fictives
- `back/database/users.sql` : Les utilisateurs de la BDD

## Emails

Les emails peuvent être envoyés :
- Soit réellement par le serveur sur lequel est hébergé l'application, en configurant le fichier `back/config.php` avec `define('EMAIL_FAKE', false);`
- Soit pour de faux, en configurant le fichier `back/config.php` avec `define('EMAIL_FAKE', true);`

Dans cette dernière configuration, les emails sont stockés dans le dossier `back/emails/` au lieu d'être envoyés.

## Helpers

C'est ici que sont stockées les fonctions réutilisables. Les fonctions sont stocké horizontalement, c'est à dire que chaque fonction est dans un fichier différent.
Chaque fichier est nommé et doit être nommé en fonction de la fonction qu'il contient.

## Logs

C'est ici que sont stockés les logs de l'application, dans des fichiers `.log`.
Les logs sont créer par la fonction `log_txt` qui est dans le fichier `back/helpers/log_txt.php`

## Tests

Les tests unitaires sont dans le dossier `back/tests/`

Trois types de tests existent :
- Les tests de contrôleurs : `back/tests/controllers/`
- Les tests fonctions utilitaires : `back/tests/helpers/`
- Les tests de classes utilitaires : `back/tests/utils/`

Dans tout les cas, chacun de ces fichiers de tests contient une classe qui hérite de `back/tests/base/Test.php`.

Les tests sont appelés par le fichier `back/tests/index.php`. Ce fichier peut être appelé par un navigateur, ou par la ligne de commande.
Dans ce premier cas, veillez à bien configurer le fichier `.htaccess` pour autoriser l'accès à ce fichier.

Chaque fichier de test doit être nommé en fonction de la fonction qu'il teste : `back/tests/helpers/image_or_placeholder.php` teste la fonction `image_or_placeholder` qui est dans le fichier `back/helpers/TestImageOrPlaceholder.php`

## Uploads

Les fichiers uploadés par les administrateurs du site sont stockés dans le dossier `back/uploads/`.

C'est la fonction `back/tests/helpers/image_or_placeholder.php` qui viendra chercher les images dans ce dossier.

## Utils

C'est ici que sont stockées les classes réutilisables.

C'est ici, dans le fichier `back/utils/database.php`, que se trouve la classe `Database` qui permet de se connecter à la base de données.
Cette classe est utilisée par les controlleurs pour gérer les requêtes SQL.
