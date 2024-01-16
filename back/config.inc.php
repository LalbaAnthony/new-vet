<?php

/**
 * Vide le cache du navigateur
 */
header("Cache-Control: no-cache, must-revalidate");
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");

/**
 * Paramétrage pour certains serveurs qui n'affichent pas les erreurs PHP par défaut
 */
ini_set('display_errors', '1');
ini_set('html_errors', '1');

/**
 * Démarrage de la session
 */
session_start();

/**
 * Inclusion des fichiers nécessaires
 */
include_once('helpers/log_txt.php');
include_once('helpers/db_connect.php');

/**
 * Paramètre de la base de données
 */
define('DB_USER', 'new-vet-user');
define('DB_PASSWORD', 'w11xBg50G2t4YtC1BlbQ');
define('DB_HOST', 'localhost');
define('DB_NAME', 'new-vet');

/**
 * Paramètre de l'application
 */
define('APP_NAME', 'NewVet');
define('APP_URL', 'http://localhost/projects/new-vet');
define('APP_URL_BACK', APP_URL . '/back');
define('APP_URL_API', APP_URL . '/back/api');
define('APP_PATH', dirname(__FILE__));
