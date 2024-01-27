<?php

include_once "../config.inc.php";
include_once APP_PATH . "/partials/header.php";
include_once APP_PATH . "/models/product.php";

// Réception du produit à modifier
$urlSlug = isset($_GET['slug']) ? $_GET['slug'] : '';
$product = getProduct($urlSlug);

// Modification dans la base
if (isset($_POST['submit'])) {

    // Formulaire validé : on supprime l'enregistrement
    deleteProduct($product['slug']);

    // Redirection vers la liste des produits
    header('Location:' . APP_URL . 'products/index.php?delete=success');
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
    <link href="<?= APP_URL ?>css/bootstrap.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h2 class="mb-4">Suppression de : <?= $product['name'] ?></h2>

        <form action="<?= $_SERVER['PHP_SELF']; ?>" method="post" class="mb-5">
            <input type="hidden" name="slug" id="slug" value="<?= $product['slug']; ?>">
            <div class="form-group">
                <label for="name">Nom:</label>
                <input class="form-control" type="text" id="name" name="name" disabled value="<?= $product['name'] ?>">
            </div>

            <div class="form-group">
                <label for="description">Description:</label>
                <input class="form-control" type="text" id="description" name="description" disabled value="<?= $product['description'] ?>">
            </div>

            <div class="form-group">
                <label for="price">Prix:</label>
                <input class="form-control" type="text" id="price" name="price" disabled value="<?= $product['price'] ?>">
            </div>

            <div class="form-group">
                <label for="stock_quantity">Quantité:</label>
                <input class="form-control" type="text" id="stock_quantity" name="stock_quantity" disabled value="<?= $product['stock_quantity'] ?>">
            </div>

            <div class="form-group">
                <label for="is_highlander">Highlander:</label>
                <input type="checkbox" id="is_highlander" name="is_highlander" disabled <?php echo $product['is_highlander'] === 1 ? 'checked' : '' ?>>
            </div>

            <div class="d-flex justify-content-between">
                <a href="<?= APP_URL ?>products/index.php" class="btn btn-secondary">Retour</a>
                <button type="submit" name="submit" class="btn btn-danger">Supprimer</button>
            </div>
        </form>
    </div>


</body>

</html>