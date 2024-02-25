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
 * Paramètre de la base de données
 */
define('DB_USER', 'new-vet-user');
define('DB_PASSWORD', 'w11xBg50G2t4YtC1BlbQ');
define('DB_HOST', 'localhost');
define('DB_NAME', 'new-vet');

/**
 * Paramètre de l'application for XAMPP
 */
define('APP_NAME', 'NewVet');
define('FRONT_URL', 'http://localhost:5173/');
define('APP_PATH', '/xampp/htdocs/projects/new-vet/back/');
define('APP_URL', 'http://localhost/projects/new-vet/back/');

/**
 * Démarrage de la session
 */
session_start();

/**
 * Inclusion des fichiers nécessaires
 */
include_once APP_PATH . 'helpers/log_txt.php';
include_once APP_PATH . 'helpers/db_connect.php';
