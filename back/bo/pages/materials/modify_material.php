<?php

require_once "../../../config.inc.php";
include_once APP_PATH . "controllers/material.php";

// Réception du contenu à modifier
$urlSlug = isset($_GET['slug']) ? $_GET['slug'] : '';

$material = getMaterial($urlSlug);

// Modification dans la base
if (isset($_POST['submit'])) {

    // Lecture du formulaire
    $material['slug'] = isset($_POST['slug']) ? $_POST['slug'] : null;
    $material['libelle'] = isset($_POST['libelle']) ? $_POST['libelle'] : null;
    $material['color'] = isset($_POST['color']) ? $_POST['color'] : null;

    // Formulaire validé : on modifie l'enregistrement
    $success = updateMaterial($material);

    // Redirection vers la liste des produits
    header('Location: ' . APP_URL . 'bo/pages/materials/index.php?updated=' . $success);
}

if (empty($urlSlug)) {
    // header('Location: ' . APP_URL . 'bo/pages/materials/index.php');
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

        <h2 class="mb-4">Modification de : <?= $material['libelle'] ?></h2>

        <form action="<?= $_SERVER['PHP_SELF']; ?>" method="post" class="mb-5">
        <input type="hidden" name="slug" id="slug" value="<?= $material['slug']; ?>">
        <div class="form-group my-4">
                <label class="required" for="libelle">Libelle:</label>
                <input class="form-control" type="text" id="libelle" name="libelle" value="<?= $material['libelle'] ?>" required>
            </div>

            <div class="form-group my-4">
                <label class="required" for="color">Couleur:</label>
                <input class="form-control" type="color" id="color" name="color" value="<?= $material['color'] ?>" required>
            </div>

            <div class="d-flex justify-content-between my-4">
                <a href="<?= APP_URL ?>bo/pages/materials/index.php" class="btn btn-secondary">Retour</a>
                <button type="submit" name="submit" class="btn btn-primary">Modifier</button>
            </div>
        </form>
    </div>


</body>

</html>