<?php

require_once "../../../config.inc.php";
include_once APP_PATH . "controllers/category.php";

// Réception du contenu à modifier
$urlSlug = isset($_GET['slug']) ? $_GET['slug'] : '';
$category = getCategory($urlSlug);

// Modification dans la base
if (isset($_POST['submit'])) {
    
    // Formulaire validé : on supprime l'enregistrement
    $success = putToTrashCategory($_POST['slug']);
    
    // Redirection vers la liste des produits
    header('Location: ' . APP_URL . 'bo/pages/categories/index.php?deleted=' . $success);
}

if (empty($urlSlug)) {
    // header('Location: ' . APP_URL . 'bo/pages/categories/index.php');
}


?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <link rel="icon" href="<?= APP_URL ?>assets/favicon-gear.ico">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="<?= APP_NAME ?>" />
    <title>Suppression - <?= APP_NAME ?></title>
    <link href="<?= APP_URL ?>bo/style/bootstrap.css" rel="stylesheet">
    <link href="<?= APP_URL ?>bo/style/main.css" rel="stylesheet">
</head>

<body>

    <?php include_once APP_PATH . "bo/partials/header.php"; ?>

    <div class="container mt-5">
        <h2 style="margin: 30vh 0">Supprimer <?= $category['libelle'] ?> ?</h2>

        <form action="<?= $_SERVER['PHP_SELF']; ?>" method="post" class="mb-5">
            <input type="hidden" name="slug" id="slug" value="<?= $category['slug']; ?>">

            <div class="d-flex justify-content-between">
                <a href="<?= APP_URL ?>bo/pages/categories/index.php" class="btn btn-secondary">Retour</a>
                <button type="submit" name="submit" class="btn btn-danger">Supprimer</button>
            </div>
        </form>
    </div>

</body>

</html>