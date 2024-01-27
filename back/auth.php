<?php

if (isset($_SESSION) && empty($_SESSION['admin'])) {
    header("Location: " . APP_URL . "login.php");
    exit();
}