<?php

include_once "../../config.inc.php";

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <link rel="icon" href="assets/favicon.ico">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="NEW VET" />
    <title>Accueil - NEW VET</title>
    <link href="<?= APP_URL ?>bo/style/bootstrap.css" rel="stylesheet">
    <link href="<?= APP_URL ?>bo/style/main.css" rel="stylesheet">
</head>

<body>
    <main>
        <?php include APP_PATH . "bo/partials/header.php"; ?>

        <div class="container">
            <div class="row justify-content-center align-items-center vh-100">
                <div class="col-md-4">
                    <h2 class="text-center mb-4">Bienvenue sur le back office de NEW VET</h2>
                    <p class="text-center">Vous pouvez gérer les produits et les catégories, et plein d'autres choses encore !</p>
                </div>
            </div>
        </div>
    </main>
</body>

</html>