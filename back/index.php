<?php

include_once "config.inc.php";

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <link rel="icon" href="assets/favicon.ico">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="NEW VET" />
    <title>Accueil - NEW VET</title>
    <link href="css/style.css" rel="stylesheet">
    <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js'></script>
</head>

<body>
    <main>
        <?php
        if (isset($_SESSION['admin'])) {
            include "partials/header.php";
        } else {
            header('Location: login.php');
        }
        ?>
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