<?php

require_once "../config.inc.php";

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <link rel="icon" href="<?= APP_URL ?>assets/favicon-gear.ico">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="<?= APP_NAME ?>" />
    <title>API - <?= APP_NAME ?></title>
</head>

<body>
    <h1>Error 404: cette route de l'API n'existe pas.</h1>
    <h4>Listes des routes disponibles:</h4>
    <ul>
        <?php


        $files = scandir("."); // . = dossier courant
        $files = array_slice($files, 2); // on retire les deux premiers éléments du tableau (.) et (..)
        $files = array_filter($files, function ($file) {
            return stripos($file, 'log') === false;
        }); // on dégage les fichiers de log
        $files = array_filter($files, function ($file) {
            return $file != "index.php";
        }); // on retire index.php du tableau

        foreach ($files as $file) {
            echo "<li><a href='$file'>$file</a></li>";
        }
        ?>
    </ul>

</body>

</html>