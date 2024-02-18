<?php

include_once "../../../config.inc.php";
include_once APP_PATH . "/models/product.php";

// Réception du produit à modifier
$urlSlug = isset($_GET['slug']) ? $_GET['slug'] : '';
$product = getProduct($urlSlug);

// Modification dans la base
if (isset($_POST['submit'])) {

    // Formulaire validé : on supprime l'enregistrement
    $sucess = deleteProduct($_POST['slug']);

    // Redirection vers la liste des produits
    header('Location:' . APP_URL . 'bo/pages/products/index.php?deleted=' . $sucess);
}

// Affichage
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <link rel="icon" href="assets/favicon.ico">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="NEW VET" />
    <title>Suppression - NEW VET</title>
    <link href="<?= APP_URL ?>bo/style/bootstrap.css" rel="stylesheet">
    <link href="<?= APP_URL ?>bo/style/main.css" rel="stylesheet">
</head>

<body>

    <?php include_once APP_PATH . "/bo/partials/header.php"; ?>

    <div class="container mt-5">
        <h2 style="margin: 30vh 0">Supprimer <?= $product['name'] ?> ?</h2>

        <form action="<?= $_SERVER['PHP_SELF']; ?>" method="post" class="mb-5">
            <input type="hidden" name="slug" id="slug" value="<?= $product['slug']; ?>">

            <div class="d-flex justify-content-between">
                <a href="<?= APP_URL ?>bo/pages/products/index.php" class="btn btn-secondary">Retour</a>
                <button type="submit" name="submit" class="btn btn-danger">Supprimer</button>
            </div>
        </form>
    </div>


</body>

</html>