<?php

include_once "../../../config.inc.php";
include_once APP_PATH . "/models/product.php";
include_once APP_PATH . "/helpers/fr_date.php";
include_once APP_PATH . "/helpers/three_dots_string.php";
include_once APP_PATH . "/helpers/float_to_price.php";
include_once APP_PATH . "/models/image.php";

// Get the sorting parameters from the query string
$search = isset($_GET['search']) ? $_GET['search'] : null;
$order_by = isset($_GET['order_by']) ? $_GET['order_by'] : 'created_at';
$order = isset($_GET['order']) && $_GET['order'] == 'desc' ? 'DESC' : 'ASC';
$page = isset($_GET['page']) ? $_GET['page'] : 1;

// Comput new order and sort
$new_order = $order == 'DESC' ? 'asc' : 'desc';
$sort = array(array('order' => $order, 'order_by' => $order_by));

$products_count = getProductsCount();

// Comput offset & per_page
$per_page = 10;
$offset = ($page - 1) * $per_page;
$maxPage = ceil($products_count / $per_page);

// Fetch products with sorting
$products = getProducts(null, null, $search, false, null, null, $sort, $offset, $per_page);

// Bottom action: delete selected products, ...
if (isset($_GET['delete']) && isset($_GET['selected_products'])) {
    $selected_products = explode(",", $_GET['selected_products']);
    foreach ($selected_products as $slug) {
        deleteProduct($slug);
    }
    header("Location: " . $_SERVER['PHP_SELF'] . "?deleted=1");
    exit;
}

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
    <link href="<?= APP_URL ?>bo/style/bootstrap.css" rel="stylesheet">
    <link href="<?= APP_URL ?>bo/style/main.css" rel="stylesheet">
</head>

<body>

    <?php include_once APP_PATH . "/bo/partials/header.php"; ?>

    <?php include_once APP_PATH . "/bo/partials/alert_message.php"; ?>

    <div class="container p-4 p-lg-5">
        <h1 class="text-center">Liste des produits</h1>
        <p class="text-center"><?= $products_count ?> produit<?php if ($products_count > 1) : ?>s<?php endif; ?></p>

        <!-- Barre de recherche -->
        <form class="d-flex justify-content-between my-4" method="GET">
            <input class="form-control mr-sm-2" type="search" placeholder="Rechercher" aria-label="Search" name="search" value="<?= $search ?>">
            <button class="btn btn-primary mx-2 my-sm-0" type="submit">Rechercher</button>
        </form>

        <table class="table table-striped">
            <thead>
                <tr class="table-primary">
                    <th scope='col' colspan='1'><input type="checkbox" onclick="toggleAll()"></th>
                    <th scope='col' colspan='1'>&nbsp;</th>
                    <th scope='col'><a class="text-decoration-none" href="?search=<?= $search ?>&page=<?= $page ?>&order_by=name&order=<?= $new_order ?>">Nom</a></th>
                    <th scope='col'><a class="text-decoration-none" href="?search=<?= $search ?>&page=<?= $page ?>&order_by=description&order=<?= $new_order ?>">Description</a></th>
                    <th scope='col'><a class="text-decoration-none" href="?search=<?= $search ?>&page=<?= $page ?>&order_by=price&order=<?= $new_order ?>">Prix</a></th>
                    <th scope='col'><a class="text-decoration-none" href="?search=<?= $search ?>&page=<?= $page ?>&order_by=stock_quantity&order=<?= $new_order ?>">Stock</a></th>
                    <th scope='col'><a class="text-decoration-none" href="?search=<?= $search ?>&page=<?= $page ?>&order_by=is_highlander&order=<?= $new_order ?>">Highlander</a></th>
                    <th scope='col'><a class="text-decoration-none" href="?search=<?= $search ?>&page=<?= $page ?>&order_by=sort_order&order=<?= $new_order ?>">Ordre</a></th>
                    <th scope='col'><a class="text-decoration-none" href="?search=<?= $search ?>&page=<?= $page ?>&order_by=created_at&order=<?= $new_order ?>">Création</a></th>
                    <th scope='col' colspan='2'>&nbsp;</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($products as $product) {
                ?>
                    <tr class="align-middle">
                        <!-- Checkbox pour la suppression multiple -->
                        <td><input id="product_<?= $product['slug'] ?>" type="checkbox" name="selected_products[]" value="<?= $product['slug'] ?>"></td>
                        <!-- Image -->
                        <td>
                            <?php
                            $dbImgPath = getFirstImagePathFromProduct($product['slug']);
                            $fullImgPath = APP_PATH . $dbImgPath;
                            ?>
                            <?php if ($dbImgPath && file_exists($fullImgPath)) : ?>
                                <img src="<?= APP_URL . $dbImgPath ?>" class="img-thumbnail" width="100">
                            <?php else : ?>
                                <img src="<?= APP_URL ?>assets/img/default-img.webp" class="img-thumbnail" width="100">
                            <?php endif; ?>
                        </td>
                        <!-- Nom -->
                        <td><?= $product['name'] ?></td>
                        <!-- Description -->
                        <td><?= three_dots_string($product['description'], 20) ?></td>
                        <!-- Prix -->
                        <td><?= float_to_price($product['price']) ?></td>
                        <!-- Stock -->
                        <?php if ($product['stock_quantity'] > 0) : ?>
                            <td><?= $product['stock_quantity'] ?> unités</td>
                        <?php else : ?>
                            <td class="text-danger">Rupture</td>
                        <?php endif; ?>
                        <!-- Highlander -->
                        <td><?= $product['is_highlander'] == 1 ? 'Oui' : '-' ?></td>
                        <!-- Ordre d'affichage -->
                        <td><?= $product['sort_order'] ? $product['sort_order'] : '-' ?></td>
                        <!-- Date de création -->
                        <td><?= fr_date($product['created_at']) ?></td>
                        <!-- Bouton de modification -->
                        <td> <a href="<?= APP_URL ?>bo/pages/products/modifiy_product.php?slug=<?= $product['slug'] ?>" class="btn btn-primary btn-sm">Modifier</a> </td>
                        <!-- Bouton de suppression -->
                        <td> <a href="<?= APP_URL ?>bo/pages/products/delete_product.php?slug=<?= $product['slug'] ?>" class="btn btn-danger btn-sm">Supprimer</a> </td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
        <!-- Pagination -->
        <div class="d-flex justify-content-between my-2">
            <!-- Page précédente -->
            <?php if ($page > 1) : ?>
                <a href="?search=<?= $search ?>&page=<?= $page - 1 ?>&order_by=<?= $order_by ?>&order=<?= $order ?>">Page précédent (<?= $page - 1 ?>)</a>
            <?php else : ?>
                <span>&nbsp;</span>
            <?php endif; ?>
            <!-- Page Actuelle -->
            <span>Page <?= $page ?></span>
            <!-- Page suivante -->
            <?php if ($page < $maxPage) : ?>
                <a href="?search=<?= $search ?>&page=<?= $page + 1 ?>&order_by=<?= $order_by ?>&order=<?= $order ?>">Page suivant (<?= $page + 1 ?>)</a>
            <?php else : ?>
                <span>&nbsp;</span>
            <?php endif; ?>
        </div>
        <!-- Actions en bas de page -->
        <div class="d-flex justify-content-start gap-2 my-5">
            <button id="delete-products" class="btn btn-danger" disabled onclick="deleteSelectedProducts()">Supprimer</button>
            <a href="<?= APP_URL ?>bo/pages/products/create_product.php" class="btn btn-primary">Ajouter</a>
        </div>
    </div>


</body>

</html>

<script>
    // Fonction disbale suppr button
    function disableSupprButton() {
        var btn = document.getElementById('delete-products');
        btn.disabled = true;
    }

    // Fonction enable suppr button
    function enableSupprButton() {
        var btn = document.getElementById('delete-products');
        btn.disabled = false;
    }

    // Fonction pour cocher/décocher toutes les cases
    function toggleAll() {
        var checkboxes = document.getElementsByName('selected_products[]');
        for (var checkbox of checkboxes) {
            checkbox.checked = event.target.checked;
        }
        if (event.target.checked) {
            enableSupprButton();
        } else {
            disableSupprButton();
        }
    }

    // Fonction pour supprimer les produits sélectionnés
    function deleteSelectedProducts() {
        var checkboxes = document.getElementsByName('selected_products[]');
        var selected_products = [];
        for (var checkbox of checkboxes) {
            if (checkbox.checked) {
                selected_products.push(checkbox.value);
            }
        }
        if (selected_products.length > 0) {
            if (confirm("Voulez-vous vraiment supprimer les éléments sélectionnés ?")) {
                window.location.href = "<?= $_SERVER['PHP_SELF'] ?>?delete&selected_products=" + selected_products.join(",");
            }
        } else {
            alert("Vous devez sélectionner au moins un élément à supprimer");
        }
    }

    // Désactiver le bouton de suppression si aucune case n'est cochée
    var checkboxes = document.getElementsByName('selected_products[]');
    for (var checkbox of checkboxes) {
        checkbox.addEventListener('change', function() {
            if (this.checked) {
                enableSupprButton();
            } else {
                disableSupprButton();
            }
        });
    }
</script>