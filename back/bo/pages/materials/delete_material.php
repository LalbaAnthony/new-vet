<?php 

require_once "../../../config.inc.php";
include_once APP_PATH . "controllers/material.php";

$url_slug = isset($_GET['slug']) ? $_GET['slug'] : '';
$material =  getMaterial($url_slug);

// Modification dans la base
if (isset($_POST['submit'])) {
    
    // Formulaire validé : on supprime l'enregistrement
    $success = putToTrashMaterial($_POST['slug']);
    
    // Redirection vers la liste des contacts
    header('Location: ' . APP_URL . 'bo/pages/materials/index.php?deleted=' . $success);
}

if (empty($urlSlug)) {
    header('Location: ' . APP_URL . 'bo/pages/products/index.php');
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
        <h2 class="mb-4">Suppression de ce matériau ?</h2>

        <form action="<?= $_SERVER['PHP_SELF']; ?>" method="post" class="mb-5">
            <input type="hidden" name="slug" id="slug" value="<?= $material['slug']; ?>">

            <div class="d-flex justify-content-between">
                <a href="<?= APP_URL ?>bo/pages/matérial/index.php" class="btn btn-secondary">Retour</a>
                <button type="submit" name="submit" class="btn btn-danger">Supprimer</button>
            </div>
        </form>
    </div>


</body>

</html>

?> 