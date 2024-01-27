<?php

include_once "../config.inc.php";
include_once APP_PATH . "/partials/header.php";
include_once APP_PATH . "/models/product.php";
include_once APP_PATH . "/models/category.php";
include_once APP_PATH . "/models/material.php";


// Réception du produit à modifier
$urlSlug = isset($_GET['slug']) ? $_GET['slug'] : '';
$product = getProduct($urlSlug);

// Réception des tables enfants
// $categories = getCategories();
// $materials = getMaterials();

// Modification dans la base
if (isset($_POST['submit'])) {

    // Lecture du formulaire 
    $product['slug'] = isset($_POST['slug']) ? $_POST['slug'] : $product['slug'];
    $product['name'] = isset($_POST['name']) ? $_POST['name'] : $product['name'];
    $product['description'] = isset($_POST['description']) ? $_POST['description'] : $product['description'];
    $product['price'] = isset($_POST['price']) ? $_POST['price'] : $product['price'];
    $product['stock_quantity'] = isset($_POST['stock_quantity']) ? $_POST['stock_quantity'] : $product['stock_quantity'];
    $product['is_highlander'] = isset($_POST['is_highlander']) ? (strval($_POST['is_highlander']) == "on" ? $_POST['is_highlander']  = 1 : $_POST['is_highlander']  = 0) : $product['is_highlander']; // SPOILER ALERT LES CHECLBOX C'EST DE LA MERDE

    // Formulaire validé : on modifie l'enregistrement
    $sucess = updateProduct($product);

    // Redirection vers la liste des produits
    header('Location:' . APP_URL . 'products/index.php?updated=' . $sucess);
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
    <title>Modification - NEW VET</title>
    <link href="<?= APP_URL ?>css/bootstrap.css" rel="stylesheet">
    <link href="<?= APP_URL ?>css/main.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">

        <?php if ($product["is_deleted"] == 1) : ?>
            <div class="alert alert-danger" role="alert">
                Attention, ce produit a été supprimé !
            </div>
        <?php endif; ?>

        <h2 class="mb-4">Modification de : <?= $product['name'] ?></h2>

        <form action="<?= $_SERVER['PHP_SELF']; ?>" method="post" class="mb-5">
            <input type="hidden" name="slug" id="slug" value="<?= $product['slug']; ?>">
            <div class="form-group">
                <label for="name">Nom:</label>
                <input class="form-control" type="text" id="name" name="name" value="<?= $product['name'] ?>">
            </div>

            <div class="form-group">
                <label for="description">Description:</label>
                <input class="form-control" type="text" id="description" name="description" value="<?= $product['description'] ?>">
            </div>

            <div class="form-group">
                <label for="price">Prix:</label>
                <input class="form-control" type="number" id="price" name="price" value="<?= $product['price'] ?>">
            </div>

            <div class="form-group">
                <label for="stock_quantity">Quantité:</label>
                <input class="form-control" type="number" id="stock_quantity" name="stock_quantity" value="<?= $product['stock_quantity'] ?>">
            </div>
            
            <!-- <div class="form-group">
                <label for="stock_quantity">Catégorie:</label>
                <select class="form-control" name="category_id" id="category_id">
                    <?php foreach ($categories as $category) : ?>
                        <option value="<?= $category['id'] ?>" <?php echo $category['id'] === $product['category_id'] ? 'selected' : '' ?>><?= $category['name'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div> -->

            <!-- <div class="form-group">
                <label for="stock_quantity">Materiaux:</label>
                <select class="form-control" name="material_id" id="material_id">
                    <?php foreach ($materials as $material) : ?>
                        <option value="<?= $material['id'] ?>" <?php echo $material['id'] === $product['material_id'] ? 'selected' : '' ?>><?= $material['name'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div> -->
            
            <div class="form-group my-4 p-1">
                <label for="is_highlander">Highlander:</label>
                <input type="checkbox" id="is_highlander" name="is_highlander" <?php echo $product['is_highlander'] === 1 ? 'checked' : '' ?>>
            </div>

            <div class="d-flex justify-content-between">
                <a href="<?= APP_URL ?>products/index.php" class="btn btn-secondary">Retour</a>
                <button type="submit" name="submit" class="btn btn-primary">Modifier</button>
            </div>
        </form>
    </div>


</body>

</html>