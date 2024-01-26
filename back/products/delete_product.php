<?php

include_once "../config.inc.php";
include_once "../partials/header.php";
include_once "../models/product.php";

// Connexion à la base
$dbh = db_connect();

// Récupère l'ID passé dans l'URL 
$slug = isset($_GET['slug']) ? $_GET['slug'] : '';

$submit = isset($_POST['submit']);



if ($submit) {
    $slug = isset($_POST['slug']) ? $_POST['slug'] : '';
    deleteProduct($slug);
    header("Location: index.php");
    exit();
};

$product = getProduct($slug);
if ($product) {
    $name = isset($product['name']) ? $product['name'] : '';
    $quantity = isset($product['stock_quantity']) ? $product['stock_quantity'] : '';
    $price = isset($product['price']) ? $product['price'] : '';
    $description = isset($product['description']) ? $product['description'] : '';
}

?>



<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <link rel="icon" href="assets/favicon.ico">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="NEW VET" />
    <title>Tableau de bord - NEW VET</title>
    <link href="<?= APP_PATH ?>/css/bootstrap.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h2 class="mb-4">Suppresion Produit - <?= $name ?></h2>

        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="mb-5">
            <div class="form-group">
                <label for="name">Name:</label>
                <input class="form-control" type="text" id="name" name="name" value="<?= $name ?>">
            </div>

            <div class="form-group">
                <label for="description">Description:</label>
                <input class="form-control" type="text" id="description" name="description" value="<?= $description ?>">
            </div>

            <div class="form-group">
                <label for="price">Price:</label>
                <input class="form-control" type="text" id="price" name="price" value="<?= $price ?>">
            </div>

            <div class="form-group">
                <label for="quantity">Quantity:</label>
                <input class="form-control" type="text" id="quantity" name="quantity" value="<?= $quantity ?>">
            </div>

            <input type="hidden" name="slug" id="slug" value="<?= $slug; ?>">
            <button type="submit" name="submit" class="btn btn-danger">Supprimer</button>
        </form>
    </div>


</body>

</html>