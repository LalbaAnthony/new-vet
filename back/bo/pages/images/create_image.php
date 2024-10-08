<?php

require_once "../../../config.inc.php";
include_once APP_PATH . "helpers/slugify.php";
include_once APP_PATH . "models/image.php";

// Configuration
$alowed_extensions = array("jpg", "jpeg", "png", "webp");
$max_size = 2000000; // 2 Mo

if (isset($_POST['submit'])) {

    $error = null;
    $successUpload = false;
    $successInsertDb = false;

    $extension = strtolower(pathinfo(APP_UPLOAD_PATH . basename($_FILES["image"]["name"]), PATHINFO_EXTENSION));
    $file_name = time() . '.' . $extension;
    $file_path = APP_UPLOAD_PATH . $file_name;

    // Vérifier si le fichier est une image réelle ou une fausse image
    if (isset($_POST["submit"]) && getimagesize($_FILES["image"]["tmp_name"]) === false) {
        $error = "Le fichier n'est pas une image.";
    }

    // Vérifier si le fichier existe déjà
    if (file_exists($file_path)) {
        $error = "Désolé, le fichier existe déjà.";
    }

    // Vérifier la taille du fichier
    if ($_FILES["image"]["size"] > $max_size) {
        $error = "Désolé, votre fichier est trop volumineux.";
    }

    // Autoriser certains formats de fichiers
    if (!in_array($extension, $alowed_extensions)) {
        $error = "Désolé, seuls les fichiers " . implode(", ", $alowed_extensions) . " sont autorisés.";
    }

    // Si tout est ok, téléchargez le fichier
    if (!$error) {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $file_path)) {
            $successUpload = true;
        } else {
            $error = "Désolé, une erreur inconnue s'est produite lors du téléchargement de votre fichier.";
        }
    }

    // Si tout est ok, on insère dans la base
    if (!$error) {
        $image = array();

        // Lecture du formulaire
        $image['name'] = isset($_POST['name']) ? $_POST['name'] : null;
        $image['alt'] = isset($_POST['alt']) ? $_POST['alt'] : null;
        $image['weight'] = $_FILES["image"]["size"];
        $image['extention'] = $extension;
        $image['slug'] = slugify($image['name']);
        $image['path'] = $file_name;

        // Formulaire validé : on modifie l'enregistrement
        $successInsertDb = insertImage($image);
    }

    $success = $successUpload && $successInsertDb;
    $success = $successUpload;

    if (!$success) {
        $error = "Une erreur est survenue lors de l'envoie de l'image.";
    }

    if (!$error) {
        header('Location: ' . APP_URL . 'bo/pages/images/index.php?created=' . $success);
    }
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
</head>

<body>
    <?php include_once APP_PATH . "bo/partials/header.php"; ?>
    <div class="container mt-5">

        <?php if (isset($error)) : ?>
            <div class="alert alert-danger" role="alert">
                <?= $error ?>
            </div>
        <?php endif; ?>

        <h2 class="mb-4">Ajout d'une image :</h2>

        <form action="<?= $_SERVER['PHP_SELF']; ?>" method="post" class="mb-5" enctype="multipart/form-data">
            <div class="form-group my-4">
                <label class="required" for="name">Nom:</label>
                <input class="form-control" type="text" id="name" name="name" required>
            </div>

            <div class="form-group my-4">
                <label for="alt">Description:</label>
                <input class="form-control" type="text" id="alt" name="alt">
            </div>

            <div class="form-group my-4">
                <label class="required" for="image">Image:</label>
                <input class="form-control" type="file" name="image" id="image" required>
            </div>

            <div class="d-flex justify-content-between my-4">
                <a href="<?= APP_URL ?>bo/pages/images/index.php" class="btn btn-secondary">Retour</a>
                <button type="submit" name="submit" class="btn btn-primary">Ajouter</button>
            </div>
        </form>
    </div>


</body>

</html>