<?php

include_once "config.inc.php";

if (isset($_SESSION['admin'])) log_txt("User logged out: login " . $_SESSION['admin']['login']);

session_start();
session_destroy();
header('Location:' . APP_URL . 'bo/pages/index.php');