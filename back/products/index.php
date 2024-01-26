<?php

include_once "../config.inc.php";
include_once "../partials/header.php";
include_once "../models/product.php";

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <link rel="icon" href="../assets/favicon.ico">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Site de vente de vêtement pour femme." />
    <meta name="author" content="LALBA Anthony et SIREYJOL Victor" />
    <title>Accueil - NEW VET</title>
    <link href="../css/style.css" rel="stylesheet">
    <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js'></script>
</head>

<body>
    <main>
     
        

    <?php $products =  getProducts() ;?>

    <table class="table table-striped">
    <thead>
        <tr>
            <th>Name</th>
            <th>Description</th>
            <th>Price</th>
            <th>Stock Quantity</th>
            <th>Created At</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($products as $product) {
        ?>
            <tr>
                <td><?= $product['name'] ?></td>
                <td><?= $product['description'] ?></td>
                <td><?= $product['price'] ?></td>
                <td><?= $product['stock_quantity'] ?></td>
                <td><?= $product['created_at'] ?></td>
                <td>
                    <!-- Bouton de modification -->
                    <a href="ModifierProduct.php?slug=<?= $product['slug'] ?>" class="btn btn-primary btn-sm">Modifier</a>

                    <!-- Bouton de suppression -->
                    <a href="SupprimerProduct.php?slug=<?= $product['slug'] ?>" class="btn btn-primary btn-sm">Supprimer</a>
                </td>
            </tr>
        <?php
        }
        ?>
    </tbody>
</table>


    </main>
</body>

</html>
