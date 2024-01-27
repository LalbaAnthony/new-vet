<?php

include_once "../config.inc.php";
include_once APP_PATH . "/partials/header.php";
include_once APP_PATH . "/models/product.php";
include_once APP_PATH . "/helpers/fr_date.php";
include_once APP_PATH . "/helpers/three_dots_string.php";

$products =  getProducts();

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <link rel="icon" href="../assets/favicon.ico">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Site de vente de vêtement pour femme." />
    <meta name="author" content="LALBA Anthony et SIREYJOL Victor" />
    <title>Lise des produits - NEW VET</title>
    <link href="<?= APP_URL ?>css/bootstrap.css" rel="stylesheet">
</head>

<body>
    <main>

        <?php if (isset($_GET['update'])) : ?>
            <div class="alert alert-success" role="alert">
                Le produit a bien été modifié
            </div>
        <?php endif; ?>
        <?php if (isset($_GET['delete'])) : ?>
            <div class="alert alert-success" role="alert">
                Le produit a bien été supprimé
            </div>
        <?php endif; ?>

        <div class="container p-4 p-lg-5">
            <table class="table table-striped">
                <thead>
                    <tr class="table-primary">
                        <th scope='col'>Highlander</th>
                        <th scope='col'>Nom</th>
                        <th scope='col'>Description</th>
                        <th scope='col'>Prix</th>
                        <th scope='col'>Stock</th>
                        <th scope='col'>Création</th>
                        <th scope='col' colspan='2'>&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($products as $product) {
                    ?>
                        <tr>
                            <td><?= $product['is_highlander'] == 1 ? 'Oui' : 'Non' ?></td>
                            <td><?= $product['name'] ?></td>
                            <td><?= three_dots_string($product['description'], 20) ?></td>
                            <td><?= $product['price'] ?> €</td>
                            <td><?= $product['stock_quantity'] ?> unités</td>
                            <td><?= fr_date($product['created_at']) ?></td>
                            <!-- Bouton de modification -->
                            <td> <a href="<?= APP_URL ?>products/modifiy_product.php?slug=<?= $product['slug'] ?>" class="btn btn-primary btn-sm">Modifier</a> </td>
                            <!-- Bouton de suppression -->
                            <td> <a href="<?= APP_URL ?>products/delete_product.php?slug=<?= $product['slug'] ?>" class="btn btn-danger btn-sm">Supprimer</a> </td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>


    </main>
</body>

</html>