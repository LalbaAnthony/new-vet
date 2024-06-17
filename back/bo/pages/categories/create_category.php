<?php


require_once "../../../config.inc.php";

include_once APP_PATH . "controllers/category.php";
include_once APP_PATH . "controllers/image.php";
include_once APP_PATH . "helpers/slugify.php";

// Modification dans la base
if (isset($_POST['submit'])) {

    $category = array();

    // Lecture du formulaire
    $category['libelle'] = isset($_POST['libelle']) ? $_POST['libelle'] : null;
    $category['color'] = isset($_POST['color']) ? $_POST['color'] : null;
    $category['sort_order'] = isset($_POST['sort_order']) ? $_POST['sort_order'] : null;
    $category['is_quick_access'] = isset($_POST['is_quick_access']) ? (strval($_POST['is_quick_access']) == "on" ? $_POST['is_quick_access']  = 1 : $_POST['is_quick_access'] = 0) : 0; // SPOILER ALERT LES CHECKBOXS C'EST DE LA MERDE (encore)
    $category['is_highlander'] = isset($_POST['is_highlander']) ? (strval($_POST['is_highlander']) == "on" ? $_POST['is_highlander']  = 1 : $_POST['is_highlander'] = 0) : 0; // SPOILER ALERT LES CHECKBOXS C'EST DE LA MERDE (encore)

    // Generate le slug
    $category['slug'] = slugify($category['libelle']);

    $categoryImages = isset($_POST['images_slugs']) ? $_POST['images_slugs'] : array();
    $category['image_slug'] = !empty($categoryImages) && !empty($categoryImages[0]) ? $categoryImages[0] : null;  // Prend la première image cochée

    // Formulaire validé : on modifie l'enregistrement
    $success = insertCategory($category);

    // Redirection vers la liste des produits
    header('Location: ' . APP_URL . 'bo/pages/categories/index.php?created=' . $success);
}

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

        <h2 class="mb-4">Modification d'une catégorie :</h2>

        <form action="<?= $_SERVER['PHP_SELF']; ?>" method="post" class="mb-5">
            <input type="hidden" name="slug" id="slug">
            <div class="form-group my-4">
                <label class="required" for="libelle">Nom:</label>
                <input class="form-control" type="text" id="libelle" name="libelle" required>
            </div>

            <div class="form-group my-4">
                <label class="required" for="color">Couleur:</label>
                <input class="form-control" type="color" id="color" name="color" required>
            </div>

            <div class="form-group my-4">
                <label for="sort_order">Ordre d'affichage:</label>
                <input class="form-control" type="number" id="sort_order" name="sort_order" min="1">
            </div>

            <div class="form-group my-4">
                <label for="is_highlander">Highlander:</label>
                <input type="checkbox" id="is_highlander" name="is_highlander">
            </div>

            <div class="form-group my-4">
                <label for="is_quick_access">Acces Rapide:</label>
                <input type="checkbox" id="is_quick_access" name="is_quick_access">
            </div>

            <?php
            $max_nb_images = 1;
            $selected_images = array();
            ?>
            <?php include_once APP_PATH . "bo/partials/image_select.php"; ?>

            <div class="d-flex justify-content-between my-4">
                <a href="<?= APP_URL ?>bo/pages/categories/index.php" class="btn btn-secondary">Retour</a>
                <button type="submit" name="submit" class="btn btn-primary">Ajouter</button>
            </div>
        </form>
    </div>
</body>

</html>