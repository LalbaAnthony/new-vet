<?php

include_once "../../../config.inc.php";
include_once APP_PATH . "/models/image.php";
include_once APP_PATH . "/helpers/three_dots_string.php";
include_once APP_PATH . "/helpers/fr_date.php";
include_once APP_PATH . "/helpers/nice_file_size.php";

// Get the sorting parameters from the query string
$search = isset($_GET['search']) ? $_GET['search'] : null;
$order_by = isset($_GET['order_by']) ? $_GET['order_by'] : 'created_at';
$order = isset($_GET['order']) && $_GET['order'] == 'desc' ? 'DESC' : 'ASC';
$page = isset($_GET['page']) ? $_GET['page'] : 1;

// Comput new order and sort
$new_order = $order == 'DESC' ? 'asc' : 'desc';
$sort = array(array('order' => $order, 'order_by' => $order_by));

$images_count = getImagesCount($search);

// Comput offset & per_page
$per_page = 10;
$offset = ($page - 1) * $per_page;
$maxPage = ceil($images_count / $per_page);

// Fetch images with sorting
$images = getImages($search, $sort, $offset, $per_page);

// Bottom action: delete selected images, ...
if (isset($_GET['delete']) && isset($_GET['selected_images'])) {
    $selected_images = explode(",", $_GET['selected_images']);
    foreach ($selected_images as $slug) {
        deleteImage($slug);

        // Suppression de l'image dans le dossier uploads
        $image = getImage($slug);
        $full_img_path = APP_PATH . "uploads/" . $image['path'];
        if (file_exists($full_img_path)) {
            unlink($full_img_path);
        }
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
    <title>Lise des images - <?= APP_NAME ?></title>
    <link href="<?= APP_URL ?>bo/style/bootstrap.css" rel="stylesheet">
    <link href="<?= APP_URL ?>bo/style/main.css" rel="stylesheet">
    <script src="<?= APP_URL ?>bo/script/autosubmit.js"></script>
</head>

<body>

    <?php include_once APP_PATH . "/bo/partials/header.php"; ?>

    <?php include_once APP_PATH . "/bo/partials/alert_message.php"; ?>

    <div class="container p-4 p-lg-5">
        <h1 class="text-center">Liste des images</h1>
        <p class="text-center"><?= $images_count ?> image<?php if ($images_count > 1) : ?>s<?php endif; ?></p>

        <!-- Barre de recherche -->
        <form class="d-flex justify-content-between my-4" method="GET">
            <input class="form-control mr-sm-2" id="search" type="search" placeholder="Rechercher" aria-label="Search" name="search" value="<?= $search ?>">
            <button class="btn btn-primary mx-2 my-sm-0" type="submit">Rechercher</button>
        </form>

        <div class='row gx-4 gx-lg-5'>
            <?php
            foreach ($images as $image) {
            ?>

                <div class="col-md-4 mb-5">
                    <div class="card mb-2">
                        <img src="<?= image_or_placeholder(isset($image['path']) ? $image['path'] : '') ?>" class="card-img-top object-fit-cover" alt="<?= $image['alt'] ?>" width="100%" height="200px">
                        <div class="card-body">
                            <h5 class="card-title">
                                <?= three_dots_string($image['name'], 20) ?>
                            </h5>
                            <p class="card-text">
                                <?php if ($image['created_at']) : ?>
                                    <small class="text-muted">
                                        <?= fr_date($image['created_at']) ?>
                                    </small>
                                <?php endif; ?>
                                <?php if ($image['weight'] || $image['extention']) : ?>
                                    <small class="text-muted">|</small>
                                <?php endif; ?>
                                <?php if ($image['weight']) : ?>
                                    <small class="text-muted">
                                        <?= nice_file_size($image['weight']) ?>
                                    </small>
                                <?php endif; ?>
                                <?php if ($image['extention']) : ?>
                                    <small class="text-muted">
                                        <?= strtoupper($image['extention']) ?>
                                    </small>
                                <?php endif; ?>
                            </p>
                            <div class="d-flex justify-content-between align-items-center">
                                <input type="checkbox" name="selected_images[]" value="<?= $image['slug'] ?>" onclick="enableSupprButton()">
                                <a href="<?= APP_URL ?>bo/pages/images/delete_image.php?slug=<?= $image['slug'] ?>" class="btn btn-danger">Supprimer</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>

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
            <button id="delete-images" class="btn btn-danger" disabled onclick="deleteSelectedImages()">Supprimer</button>
            <a href="<?= APP_URL ?>bo/pages/images/create_image.php" class="btn btn-primary">Ajouter</a>
        </div>
    </div>


</body>

</html>

<script>
    // Fonction disbale suppr button
    function disableSupprButton() {
        var btn = document.getElementById('delete-images');
        btn.disabled = true;
    }

    // Fonction enable suppr button
    function enableSupprButton() {
        var btn = document.getElementById('delete-images');
        btn.disabled = false;
    }

    // Fonction pour supprimer les images sélectionnés
    function deleteSelectedImages() {
        var checkboxes = document.getElementsByName('selected_images[]');
        var selected_images = [];
        for (var checkbox of checkboxes) {
            if (checkbox.checked) {
                selected_images.push(checkbox.value);
            }
        }
        if (selected_images.length > 0) {
            if (confirm("Voulez-vous vraiment supprimer les éléments sélectionnés ?")) {
                window.location.href = "<?= $_SERVER['PHP_SELF'] ?>?delete&selected_images=" + selected_images.join(",");
            }
        } else {
            alert("Vous devez sélectionner au moins un élément à supprimer");
        }
    }

    // Désactiver le bouton de suppression si aucune case n'est cochée
    var checkboxes = document.getElementsByName('selected_images[]');
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