<?php

/**
 * Paramétrage pour certains serveurs qui n'affichent pas les erreurs PHP par défaut
 */
ini_set('display_errors', '1');
ini_set('html_errors', '1');


/**
 * Functions
 */
// include('functions/helpers/XXXX.php');

spl_autoload_register('my_autoloader');

/**
 * Vide le cache du navigateur
 */
header("Cache-Control: no-cache, must-revalidate");
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");

/**
 * Paramètre de la base de données
 */
define('DB_USER', '<USER>');
define('DB_PASSWORD', '<PASS>');
define('DB_HOST', 'localhost');
define('DB_NAME', '<BASE>');