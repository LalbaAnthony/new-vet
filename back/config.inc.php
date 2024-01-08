<?php

/**
 * Paramétrage pour certains serveurs qui n'affichent pas les erreurs PHP par défaut
 */
ini_set('display_errors', '1');
ini_set('html_errors', '1');


/**
 * Functions
 */
include('helpers/log.php');

/**
 * Vide le cache du navigateur
 */
header("Cache-Control: no-cache, must-revalidate");
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");

/**
 * Paramètre de la base de données
 */
define('DB_USER', 'new-vet-user');
define('DB_PASSWORD', 'w11xBg50G2t4YtC1BlbQ');
define('DB_HOST', 'localhost');
define('DB_NAME', 'new-vet');