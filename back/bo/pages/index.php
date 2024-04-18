<?php

require_once "../../config.inc.php";

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <link rel="icon" href="<?= APP_URL ?>assets/favicon-gear.ico">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="<?= APP_NAME ?>" />
    <title>Accueil - <?= APP_NAME ?></title>
    <link href="<?= APP_URL ?>bo/style/bootstrap.css" rel="stylesheet">
    <link href="<?= APP_URL ?>bo/style/main.css" rel="stylesheet">
</head>

<body>
    <?php include APP_PATH . "bo/partials/header.php"; ?>

    <div class="container mt-5">
        <div class="container">
            <div class="row justify-content-center align-items-center" style="height: 80vh;">
                <div class="col-md-4">
                    <h2 class="text-center mb-4">Bienvenue sur le back office de <?= APP_NAME ?></h2>
                    <p class="text-center">Vous pouvez gérer les produits, les clients, les images, et plein d'autres choses encore !</p>
                    <div class="d-flex justify-content-center">
                        <a href="<?= FRONT_URL ?>" target="_blank" class="btn btn-outline-primary">Aller sur le site</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>