<?php

require_once "../../../config.inc.php";
include_once APP_PATH . "helpers/slugify.php";
include_once APP_PATH . "controllers/material.php";

// Modification dans la base
if (isset($_POST['submit'])) {

    $material = array();

    // Lecture du formulaire
    $material['libelle'] = isset($_POST['libelle']) ? $_POST['libelle'] : null;
    $material['color'] = isset($_POST['color']) ? $_POST['color'] : null;

    // Generate le slug
    $material['slug'] = slugify($material['libelle']);

    // Formulaire validé : on insert l'enregistrement
    $success = insertMaterial($material);

    // Redirection vers la liste des produits
    header('Location: ' . APP_URL . 'bo/pages/materials/index.php?created=' . $success);
}

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <link rel="icon" href="<?= APP_URL ?>assets/favicon-gear.ico">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="<?= APP_NAME ?>" />
    <title>Création - <?= APP_NAME ?></title>
    <link href="<?= APP_URL ?>bo/style/bootstrap.css" rel="stylesheet">
    <link href="<?= APP_URL ?>bo/style/main.css" rel="stylesheet">
    <script src="<?= APP_URL ?>bo/script/autosave.js"></script>
</head>

<body>

    <?php include_once APP_PATH . "bo/partials/header.php"; ?>

    <div class="container mt-5">

        <?php include_once APP_PATH . "bo/partials/alert_message.php"; ?>

        <h2 class="mb-4">Création d'un matériau :</h2>

        <form action="<?= $_SERVER['PHP_SELF']; ?>" method="post" class="mb-5">
            <div class="form-group">
                <label class="required" for="libelle">Libelle:</label>
                <input class="form-control" type="text" id="libelle" name="libelle" required>
            </div>

            <div class="form-group">
                <label class="required" for="color">Couleur:</label>
                <input class="form-control" type="color" id="color" name="color">
            </div>

            <div class="d-flex justify-content-between my-4">
                <a href="<?= APP_URL ?>bo/pages/materials/index.php" class="btn btn-secondary">Retour</a>
                <button type="submit" name="submit" class="btn btn-primary">Créer</button>
            </div>
        </form>
    </div>


</body>

</html>