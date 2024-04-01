<?php

include_once "../../../config.inc.php";
include_once APP_PATH . "/models/category.php";
include_once APP_PATH . "/helpers/fr_datetime.php";
include_once APP_PATH . "/models/image.php";

// Get the sorting parameters from the query string
$search = isset($_GET['search']) ? $_GET['search'] : null;
$order_by = isset($_GET['order_by']) ? $_GET['order_by'] : 'created_at';
$order = isset($_GET['order']) && $_GET['order'] == 'desc' ? 'DESC' : 'ASC';
$page = isset($_GET['page']) ? $_GET['page'] : 1;

// Comput new order and sort
$new_order = $order == 'DESC' ? 'asc' : 'desc';
$sort = array(array('order' => $order, 'order_by' => $order_by));

$categories_count = getCategoriesCount($search, null, null, null, null);

// Comput offset & per_page
$per_page = 10;
$offset = ($page - 1) * $per_page;
$maxPage = ceil($categories_count / $per_page);

// Fetch categories with sorting
$categories = getCategories($search, null, null, null, null, $sort, $offset, $per_page);

// Bottom action: delete selected categories, ...
if (isset($_GET['delete']) && isset($_GET['selected_categories'])) {
    $selected_categories = explode(",", $_GET['selected_categories']);
    foreach ($selected_categories as $slug) {
        deleteCategory($slug);
    }
    header("Location: " . $_SERVER['PHP_SELF'] . "?deleted=1");
    exit;
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <link rel="icon" href="<?= APP_URL ?>assets/favicon-gear.ico">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Site de vente de vêtement pour femme." />
    <meta name="author" content="LALBA Anthony et SIREYJOL Victor" />
    <title>Lise des catégories - NEW VET</title>
    <link href="<?= APP_URL ?>bo/style/bootstrap.css" rel="stylesheet">
    <link href="<?= APP_URL ?>bo/style/main.css" rel="stylesheet">
    <script src="<?= APP_URL ?>bo/script/autosubmit.js"></script>
</head>

<body>

    <?php include_once APP_PATH . "/bo/partials/header.php"; ?>

    <?php include_once APP_PATH . "/bo/partials/alert_message.php"; ?>

    <div class="container p-4 p-lg-5">
        <h1 class="text-center">Liste des catégories</h1>
        <p class="text-center"><?= $categories_count ?> catégorie<?php if ($categories_count > 1) : ?>s<?php endif; ?></p>

        <!-- Barre de recherche -->
        <form class="d-flex justify-content-between my-4" method="GET">
            <input class="form-control mr-sm-2" id="search" type="search" placeholder="Rechercher" aria-label="Search" name="search" value="<?= $search ?>">
            <button class="btn btn-primary mx-2 my-sm-0" type="submit">Rechercher</button>
        </form>

        <table class="table table-striped">
            <thead>
                <tr class="table-primary">
                    <th scope='col' colspan='1'><input type="checkbox" onclick="toggleAll()"></th>
                    <th scope='col' colspan='1'>&nbsp;</th>
                    <th scope='col'><a class="text-decoration-none" href="?search=<?= $search ?>&page=<?= $page ?>&order_by=color&order=<?= $new_order ?>">Couleur</a></th>
                    <th scope='col'><a class="text-decoration-none" href="?search=<?= $search ?>&page=<?= $page ?>&order_by=name&order=<?= $new_order ?>">Libelle</a></th>
                    <th scope='col'><a class="text-decoration-none" href="?search=<?= $search ?>&page=<?= $page ?>&order_by=is_quick_access&order=<?= $new_order ?>">Accès rapide</a></th>
                    <th scope='col'><a class="text-decoration-none" href="?search=<?= $search ?>&page=<?= $page ?>&order_by=is_highlander&order=<?= $new_order ?>">Highlander</a></th>
                    <th scope='col'><a class="text-decoration-none" href="?search=<?= $search ?>&page=<?= $page ?>&order_by=sort_order&order=<?= $new_order ?>">Ordre</a></th>
                    <th scope='col'><a class="text-decoration-none" href="?search=<?= $search ?>&page=<?= $page ?>&order_by=created_at&order=<?= $new_order ?>">Création</a></th>
                    <th scope='col' colspan='3'>&nbsp;</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($categories as $category) {
                ?>
                    <tr class="align-middle">
                        <!-- Checkbox pour la suppression multiple -->
                        <td><input id="category_<?= $category['slug'] ?>" type="checkbox" name="selected_categories[]" value="<?= $category['slug'] ?>"></td>
                        <!-- Image -->
                        <td>
                            <?php $image = getImage($category['image_slug']); ?>
                            <img src="<?= imageOrPlaceholder(isset($image['path']) ? $image['path'] : '') ?>" class="img-thumbnail" width="100">
                        </td>
                        <!-- Couleur -->
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <span style="background-color: <?= $category['color'] ?>; width: 20px; height: 20px; display: inline-block; border-radius: 50%; color; #fff"></span>
                                <span class="text-muted"><?= strtoupper($category['color']) ?></span>
                            </div>
                        </td>
                        <!-- Libelle -->
                        <td><?= $category['libelle'] ?></td>
                        <!-- Accès rapide -->
                        <td><?= $category['is_quick_access'] == 1 ? 'Oui' : '-' ?></td>
                        <!-- Highlander -->
                        <td><?= $category['is_highlander'] == 1 ? 'Oui' : '-' ?></td>
                        <!-- Ordre d'affichage -->
                        <td><?= $category['sort_order'] ? $category['sort_order'] : '-' ?></td>
                        <!-- Date de création -->
                        <td><?= fr_datetime($category['created_at']) ?></td>
                        <!-- Bouton de voir sur le site -->
                        <td><a href="<?= FRONT_URL ?>produits?categories=<?= $category['slug'] ?>" class="btn btn-outline-primary btn-sm" target="_blank">Voir</a></td>
                        <!-- Bouton de modification -->
                        <td><a href="<?= APP_URL ?>bo/pages/categories/modify_category.php?slug=<?= $category['slug'] ?>" class="btn btn-primary btn-sm">Modifier</a></td>
                        <!-- Bouton de suppression -->
                        <td><a href="<?= APP_URL ?>bo/pages/categories/delete_category.php?slug=<?= $category['slug'] ?>" class="btn btn-danger btn-sm">Supprimer</a></td>
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
            <button id="delete-categories" class="btn btn-danger" disabled onclick="deleteSelectedCategories()">Supprimer</button>
            <a href="<?= APP_URL ?>bo/pages/categories/create_category.php" class="btn btn-primary">Ajouter</a>
        </div>
    </div>
</body>

</html>

<script>
    // Fonction disbale suppr button
    function disableSupprButton() {
        var btn = document.getElementById('delete-categories');
        btn.disabled = true;
    }

    // Fonction enable suppr button
    function enableSupprButton() {
        var btn = document.getElementById('delete-categories');
        btn.disabled = false;
    }

    // Fonction pour cocher/décocher toutes les cases
    function toggleAll() {
        var checkboxes = document.getElementsByName('selected_categories[]');
        for (var checkbox of checkboxes) {
            checkbox.checked = event.target.checked;
        }
        if (event.target.checked) {
            enableSupprButton();
        } else {
            disableSupprButton();
        }
    }

    // Fonction pour supprimer les catégories sélectionnés
    function deleteSelectedCategories() {
        var checkboxes = document.getElementsByName('selected_categories[]');
        var selected_categories = [];
        for (var checkbox of checkboxes) {
            if (checkbox.checked) {
                selected_categories.push(checkbox.value);
            }
        }
        if (selected_categories.length > 0) {
            if (confirm("Voulez-vous vraiment supprimer les éléments sélectionnés ?")) {
                window.location.href = "<?= $_SERVER['PHP_SELF'] ?>?delete&selected_categories=" + selected_categories.join(",");
            }
        } else {
            alert("Vous devez sélectionner au moins un élément à supprimer");
        }
    }

    // Désactiver le bouton de suppression si aucune case n'est cochée
    var checkboxes = document.getElementsByName('selected_categories[]');
    for (var checkbox of checkboxes) {
        checkbox.addEventListener('change', function() {
            if (this.checked || document.querySelector('input[name="selected_images[]"]:checked')) {
                enableSupprButton();
            } else {
                disableSupprButton();
            }
        });
    }
</script>