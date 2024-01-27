<?php

include_once "../config.inc.php";
include_once APP_PATH . "/partials/header.php";
include_once APP_PATH . "/models/product.php";
include_once APP_PATH . "/helpers/slugify.php";

// Modification dans la base
if (isset($_POST['submit'])) {

    $product = array();
    $missing_fields = array();

    // Lecture du formulaire
    $product['name'] = isset($_POST['name']) ? $_POST['name'] : null;
    $product['description'] = isset($_POST['description']) ? $_POST['description'] : null;
    $product['price'] = isset($_POST['price']) ? $_POST['price'] : null;
    $product['stock_quantity'] = isset($_POST['stock_quantity']) ? $_POST['stock_quantity'] : null;
    $product['is_highlander'] = isset($_POST['is_highlander']) ? $_POST['is_highlander'] : null;
    $product['is_highlander'] = isset($_POST['is_highlander']) ? (strval($_POST['is_highlander']) == "on" ? $_POST['is_highlander']  = 1 : $_POST['is_highlander']  = 0) : 0; // SPOILER ALERT LES CHECLBOX C'EST DE LA MERDE (encore)

    // Generate le slug
    $product['slug'] = slugify($product['name']);

    // Formulaire validé : on modifie l'enregistrement
    $sucess = insertProduct($product);

    // Redirection vers la liste des produits
    header('Location:' . APP_URL . 'products/index.php?created=' . $sucess);
}

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <link rel="icon" href="assets/favicon.ico">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="NEW VET" />
    <title>Modification - NEW VET</title>
    <link href="<?= APP_URL ?>css/bootstrap.css" rel="stylesheet">
    <link href="<?= APP_URL ?>css/main.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">

        <?php include_once APP_PATH . "/partials/alert_message.php"; ?>

        <h2 class="mb-4">Création d'un produit :</h2>

        <form action="<?= $_SERVER['PHP_SELF']; ?>" method="post" class="mb-5">
            <div class="form-group">
                <label for="name">Nom:</label>
                <input class="form-control" type="text" id="name" name="name" required>
            </div>

            <div class="form-group">
                <label for="description">Description:</label>
                <input class="form-control" type="text" id="description" name="description" required>
            </div>

            <div class="form-group">
                <label for="price">Prix:</label>
                <input class="form-control" type="number" id="price" name="price" required>
            </div>

            <div class="form-group">
                <label for="stock_quantity">Quantité:</label>
                <input class="form-control" type="number" id="stock_quantity" name="stock_quantity" required>
            </div>

            <div class="form-group my-4 p-1">
                <label for="is_highlander">Highlander:</label>
                <input type="checkbox" id="is_highlander" name="is_highlander">
            </div>

            <div class="d-flex justify-content-between">
                <a href="<?= APP_URL ?>products/index.php" class="btn btn-secondary">Retour</a>
                <button type="submit" name="submit" class="btn btn-primary">Créer</button>
            </div>
        </form>
    </div>


</body>

</html>