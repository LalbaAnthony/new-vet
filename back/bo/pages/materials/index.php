<?php

include_once "../../../config.inc.php";
include_once APP_PATH . "/models/material.php";
include_once APP_PATH . "/helpers/fr_datetime.php";

// Get the sorting parameters from the query string
$search = isset($_GET['search']) ? $_GET['search'] : null;
$order_by = isset($_GET['order_by']) ? $_GET['order_by'] : 'created_at';
$order = isset($_GET['order']) && $_GET['order'] == 'desc' ? 'DESC' : 'ASC';
$page = isset($_GET['page']) ? $_GET['page'] : 1;

// Comput new order and sort
$new_order = $order == 'DESC' ? 'asc' : 'desc';
$sort = array(array('order' => $order, 'order_by' => $order_by));

$materials_count = getMaterialsCount($search);

// Comput offset & per_page
$per_page = 10;
$offset = ($page - 1) * $per_page;
$maxPage = ceil($materials_count / $per_page);

// Fetch materials  with sorting
$materials = getMaterials($search, $sort, $offset, $per_page);

// Bottom action: delete selected materials, ...
if (isset($_GET['delete']) && isset($_GET['selected_materials'])) {
    $selected_materials = explode(",", $_GET['selected_materials']);
    foreach ($selected_materials as $slug) {
        deleteMaterial($slug);
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
    <meta name="author" content="<?= APP_NAME ?>" />
    <title>Lise des matériaux - <?= APP_NAME ?></title>
    <link href="<?= APP_URL ?>bo/style/bootstrap.css" rel="stylesheet">
    <link href="<?= APP_URL ?>bo/style/main.css" rel="stylesheet">
    <script src="<?= APP_URL ?>bo/script/autosubmit.js"></script>
</head>

<body>
    <?php include_once APP_PATH . "/bo/partials/header.php"; ?>

    <?php include_once APP_PATH . "/bo/partials/alert_message.php"; ?>

    <div class="container p-4 p-lg-5">
        <h1 class="text-center">Liste des matériaux</h1>
        <p class="text-center"><?= $materials_count ?> <?php if ($materials_count == 1) : ?>matérial<?php endif; ?> matériaux</p>


        <!-- Barre de recherche -->
        <form class="d-flex justify-content-between my-4" method="GET">
            <input class="form-control mr-sm-2" id="search" type="search" placeholder="Rechercher" aria-label="Search" name="search" value="<?= $search ?>">
            <button class="btn btn-primary mx-2 my-sm-0" type="submit">Rechercher</button>
        </form>

        <table class="table table-striped">
            <thead>
                <tr class="table-primary">
                    <th scope='col' colspan='1'><input type="checkbox" onclick="toggleAll()"></th>
                    <th scope='col'><a class="text-decoration-none" href="?search=<?= $search ?>&page=<?= $page ?>&order_by=color&order=<?= $new_order ?>">Couleur</a></th>
                    <th scope='col'><a class="text-decoration-none" href="?search=<?= $search ?>&page=<?= $page ?>&order_by=libelle&order=<?= $new_order ?>">Libelle</a></th>
                    <th scope='col'><a class="text-decoration-none" href="?search=<?= $search ?>&page=<?= $page ?>&order_by=created_at&order=<?= $new_order ?>">Création</a></th>
                    <th scope='col' colspan='3'>&nbsp;</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($materials as $material) {
                ?>
                    <tr class="align-middle">
                        <!-- Checkbox pour la suppression multiple -->
                        <td><input id="slug" type="checkbox" name="selected_materials[]" value="<?= $material['slug'] ?>"></td>
                        <!-- Couleur -->
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <span style="background-color: <?= $material['color'] ?>; width: 20px; height: 20px; display: inline-block; border-radius: 50%; color; #fff"></span>
                                <span class="text-muted"><?= strtoupper($material['color']) ?></span>
                            </div>
                        </td>
                        <!-- Libelle -->
                        <td><?= $material['libelle'] ?></td>
                        <!-- Date -->
                        <td><?= fr_datetime($material['created_at']) ?></td>
                        <!-- Bouton de voir sur le site -->
                        <td><a href="<?= FRONT_URL ?>produits?materials=<?= $material['slug'] ?>" class="btn btn-outline-primary btn-sm" target="_blank">Voir</a></td>
                        <!-- Bouton de modification -->
                        <td><a href="<?= APP_URL ?>bo/pages/materials/modify_material.php?slug=<?= $material['slug'] ?>" class="btn btn-primary btn-sm">Modifier</a></td>
                        <!-- Bouton de suppression -->
                        <td><a href="<?= APP_URL ?>/bo/pages/materials/delete_material.php?slug=<?= $material['slug'] ?>" class="btn btn-danger btn-sm">Supprimer</a></td>
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
            <button id="delete-material" class="btn btn-danger" disabled onclick="deleteSelectedMaterial()">Supprimer</button>
            <a href="<?= APP_URL ?>bo/pages/materials/create_material.php" class="btn btn-primary">Ajouter</a>
        </div>
    </div>
</body>

</html>

<script>
    // Fonction disbale suppr button
    function disableSupprButton() {
        var btn = document.getElementById('delete-materials');
        btn.disabled = true;
    }

    // Fonction enable suppr button
    function enableSupprButton() {
        var btn = document.getElementById('delete-materials');
        btn.disabled = false;
    }

    // Fonction pour cocher/décocher toutes les cases
    function toggleAll() {
        var checkboxes = document.getElementsByName('selected_materials[]');
        for (var checkbox of checkboxes) {
            checkbox.checked = event.target.checked;
        }
        if (event.target.checked) {
            enableSupprButton();
        } else {
            disableSupprButton();
        }
    }

    // Fonction pour supprimer les materials sélectionnés
    function deleteSelectedmaterials() {
        var checkboxes = document.getElementsByName('selected_materials[]');
        var selected_materials = [];
        for (var checkbox of checkboxes) {
            if (checkbox.checked) {
                selected_materials.push(checkbox.value);
            }
        }
        if (selected_materials.length > 0) {
            if (confirm("Voulez-vous vraiment supprimer les éléments sélectionnés ?")) {
                window.location.href = "<?= $_SERVER['PHP_SELF'] ?>?delete&selected_materials=" + selected_materials.join(",");
            }
        } else {
            alert("Vous devez sélectionner au moins un élément à supprimer");
        }
    }

    // Désactiver le bouton de suppression si aucune case n'est cochée
    var checkboxes = document.getElementsByName('selected_materials[]');
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