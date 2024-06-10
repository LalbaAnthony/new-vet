<?php

require_once "../../../config.inc.php";

include_once APP_PATH . "controllers/category.php";
include_once APP_PATH . "controllers/image.php";

// Réception du produit à modifier
$urlSlug = isset($_GET['slug']) ? $_GET['slug'] : '';

if (empty($urlSlug)) {
    header('Location: ' . APP_URL . 'bo/pages/categories/index.php');
}

$category = getcategory($urlSlug);
$image = getImage($category['image_slug']);

// Modification dans la base
if (isset($_POST['submit'])) {

    // Lecture du formulaire
    $category['slug'] = isset($_POST['slug']) ? $_POST['slug'] : $category['slug'];
    $category['libelle'] = isset($_POST['libelle']) ? $_POST['libelle'] : $category['libelle'];
    $category['sort_order'] = isset($_POST['sort_order']) ? $_POST['sort_order'] : null;
    $category['color'] = isset($_POST['color']) ? $_POST['color'] : null;
    $category['is_highlander'] = isset($_POST['is_highlander']) ? (strval($_POST['is_highlander']) == "on" ? $_POST['is_highlander']  = 1 : $_POST['is_highlander'] = 0) : 0;
    $category['is_quick_access'] = isset($_POST['is_quick_access']) ? (strval($_POST['is_quick_access']) == "on" ? $_POST['is_quick_access']  = 1 : $_POST['is_quick_access'] = 0) : 0;
    $categoryImages = isset($_POST['images_slugs']) ? $_POST['images_slugs'] : array();

    // Formulaire validé : on modifie l'enregistrement
    $success = updatecategory($category);

    // Redirection vers la liste des produits
    header('Location: ' . APP_URL . 'bo/pages/categories/index.php?updated=' . $success);
}

// Affichage
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <link rel="icon" href="<?= APP_URL ?>assets/favicon-gear.ico">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="<?= APP_NAME ?>" />
    <title>Modification - <?= APP_NAME ?></title>
    <link href="<?= APP_URL ?>bo/style/bootstrap.css" rel="stylesheet">
    <link href="<?= APP_URL ?>bo/style/main.css" rel="stylesheet">
</head>

<body>

    <?php include_once APP_PATH . "bo/partials/header.php"; ?>

    <div class="container mt-5">

        <?php include_once APP_PATH . "bo/partials/alert_message.php"; ?>

        <h2 class="mb-4">Modification de : <?= $category['libelle'] ?></h2>

        <form action="<?= $_SERVER['PHP_SELF']; ?>" method="post" class="mb-5">
            <input type="hidden" name="slug" id="slug" value="<?= $category['slug']; ?>">
            <div class="form-group">
                <label class="required" for="libelle">Nom:</label>
                <input class="form-control" type="text" id="libelle" name="libelle" value="<?= $category['libelle'] ?>" required>
            </div>

            <div class="form-group">
                <label class="required" for="color">Couleur:</label>
                <input class="form-control" type="color" id="color" name="color" value="<?= $category['color'] ?>" required>
            </div>

            <div class="form-group">
                <label for="sort_order">Ordre d'affichage:</label>
                <input class="form-control" type="number" id="sort_order" name="sort_order" value="<?= $category['sort_order'] ?>" min="1">
            </div>



            <div class="form-group my-4 p-1">
                <label for="is_highlander">Highlander:</label>
                <input type="checkbox" id="is_highlander" name="is_highlander" <?php echo $category['is_highlander'] === 1 ? 'checked' : '' ?>>
            </div>

            <div class="form-group my-4 p-1">
                <label for="is_quick_access">Acces Rapide:</label>
                <input type="checkbox" id="is_quick_access" name="is_quick_access" <?php echo $category['is_quick_access'] === 1 ? 'checked' : '' ?>>
            </div>

            <div class="form-group my-4 p-1">
                <label for="is_deleted">A Supprimer :</label>
                <input type="checkbox" id="is_deleted" name="is_deleted" <?php echo $category['is_deleted'] === 1 ? 'checked' : '' ?>>
            </div>


            <?php
            $max_nb_images = 1;
            $selected_images = array();
            foreach ($categoryImages as $image) $selected_images[] = $image['slug'];
            ?>
            <?php include_once APP_PATH . "bo/partials/image_select.php"; ?>

            <div class="d-flex justify-content-between my-4">
                <a href="<?= APP_URL ?>bo/pages/categories/index.php" class="btn btn-secondary">Retour</a>
                <button type="submit" name="submit" class="btn btn-primary">Modifier</button>
            </div>
        </form>
    </div>


</body>

</html>