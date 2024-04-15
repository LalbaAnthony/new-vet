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
 * Paramètre de l'envoi d'email
 */
define('EMAIL_FROM', 'new-vet@noreply.com');

/**
 * Paramètre de l'application
 */
define('APP_NAME', 'NEW VET');
define('APP_DEBUG', false);

/**
 * Paramètre de l'application for, here for a XAMPP / LOCALHOST environment
 */
define('FRONT_URL', 'http://localhost:5173/');
define('APP_PATH', '/xampp/htdocs/projects/new-vet/back/');
define('APP_URL', 'http://localhost/projects/new-vet/back/');
define('UPLOAD_PATH', '/xampp/htdocs/projects/new-vet/back/uploads/');
define('UPLOAD_URL', 'http://localhost/projects/new-vet/back/uploads/');

/**
 * Démarrage de la session
 */
session_start();

/**
 * Inclusion des fichiers nécessaires
 */
include_once APP_PATH . 'utils/database.php';
include_once APP_PATH . 'helpers/log_txt.php';
include_once APP_PATH . 'helpers/db_connect.php';
include_once APP_PATH . 'helpers/dd.php';
include_once APP_PATH . 'helpers/get_post_dump.php';
include_once APP_PATH . 'helpers/image_or_placeholder.php';

/**
 * Paramétrage de la langue
 */
setlocale(LC_TIME, 'fr_FR.UTF-8', 'fra');
date_default_timezone_set('Europe/Paris');
