<?php

include_once "../config.inc.php";
include_once APP_PATH . "/partials/header.php";
include_once APP_PATH . "/models/product.php";
include_once APP_PATH . "/helpers/slugify.php";
include_once APP_PATH . "/models/category.php";
include_once APP_PATH . "/models/material.php";

// Réception des tables enfants
$categories = getCategories();
$materials = getMaterials();

// Modification dans la base
if (isset($_POST['submit'])) {

    $product = array();
    $missing_fields = array();

    // Lecture du formulaire
    $product['name'] = isset($_POST['name']) ? $_POST['name'] : null;
    $product['description'] = isset($_POST['description']) ? $_POST['description'] : null;
    $product['price'] = isset($_POST['price']) ? $_POST['price'] : null;
    $product['sort_order'] = isset($_POST['sort_order']) ? $_POST['sort_order'] : null;
    $product['stock_quantity'] = isset($_POST['stock_quantity']) ? $_POST['stock_quantity'] : null;
    $product['is_highlander'] = isset($_POST['is_highlander']) ? $_POST['is_highlander'] : null;
    $product['is_highlander'] = isset($_POST['is_highlander']) ? (strval($_POST['is_highlander']) == "on" ? $_POST['is_highlander']  = 1 : $_POST['is_highlander']  = 0) : 0; // SPOILER ALERT LES CHECLBOX C'EST DE LA MERDE (encore)

    $productsMaterials = isset($_POST['categories_slugs']) ? $_POST['categories_slugs'] : array();
    $productsCategories = isset($_POST['materials_slugs']) ? $_POST['materials_slugs'] : array();

    // Generate le slug
    $product['slug'] = slugify($product['name']);

    // Formulaire validé : on modifie l'enregistrement
    $sucessProduct = insertProduct($product);

    $sucessProductCat = updateProductCategories($product['slug'], $productsMaterials);
    $sucessProductMat = updateProductMaterials($product['slug'], $productsCategories);

    $sucess = $sucessProduct && $sucessProductCat && $sucessProductMat;

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
                <label for="sort_order">Ordre d'affichage:</label>
                <input class="form-control" type="number" id="sort_order" name="sort_order">
            </div>

            <div class="form-group">
                <label for="stock_quantity">Quantité en stock:</label>
                <input class="form-control" type="number" id="stock_quantity" name="stock_quantity" required>
            </div>

            <div class="form-group">
                <label for="categories_slugs">Catégorie:</label>
                <select class="form-control" name="categories_slugs[]" id="categories_slugs" multiple>
                    <?php foreach ($categories as $category) : ?>
                        <option value="<?= $category['slug'] ?>"><?= $category['libelle'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="materials_slugs">Materiaux:</label>
                <select class="form-control" name="materials_slugs[]" id="materials_slugs" multiple>
                    <?php foreach ($materials as $material) : ?>
                        <option value="<?= $material['slug'] ?>"><?= $material['libelle'] ?></option>
                    <?php endforeach; ?>
                </select>
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