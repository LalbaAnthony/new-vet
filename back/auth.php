<?php

if (isset($_SESSION) && empty($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}
