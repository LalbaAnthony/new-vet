<?php

if (empty($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}
