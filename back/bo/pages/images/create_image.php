<?php

include_once "../../../config.inc.php";

// Configuration
$target_path = APP_PATH . "uploads/";
$alowed_extensions = array("jpg", "jpeg", "png", "webp");
$max_size = 2000000; // 2 Mo

if (isset($_POST['submit'])) {

    $error = null;

    $target_file = $target_path . basename($_FILES["image"]["name"]);
    $extension = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Vérifier si le fichier est une image réelle ou une fausse image
    if (isset($_POST["submit"]) && getimagesize($_FILES["image"]["tmp_name"]) === false) {
        $error = "Le fichier n'est pas une image.";
    }

    // Vérifier si le fichier existe déjà
    if (file_exists($target_file)) {
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

    if (!$error) {
        // Si tout est ok, téléchargez le fichier
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            echo "Le fichier " . htmlspecialchars(basename($_FILES["image"]["name"])) . " a été téléchargé.";
        } else {
            $error = "Désolé, une erreur inconnue s'est produite lors du téléchargement de votre fichier.";
        }
    }

    if ($error) {
        echo $error;
    } else {
        echo "Le fichier a été téléchargé avec succès";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <link rel="icon" href="assets/favicon.ico">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="NEW VET" />
    <title>Création - NEW VET</title>
    <link href="<?= APP_URL ?>bo/style/bootstrap.css" rel="stylesheet">
    <link href="<?= APP_URL ?>bo/style/main.css" rel="stylesheet">
</head>

<body>
    <?php include_once APP_PATH . "/bo/partials/header.php"; ?>
    <div class="container mt-5">

        <?php include_once APP_PATH . "/bo/partials/alert_message.php"; ?>

        <h2 class="mb-4">Ajout d'une image :</h2>

        <form action="<?= $_SERVER['PHP_SELF']; ?>" method="post" class="mb-5" enctype="multipart/form-data">
            <div class="form-group">
                <label class="required" for="name">Nom:</label>
                <input class="form-control" type="text" id="name" name="name" required>
            </div>
            
            <div class="form-group">
                <label for="alt">Description:</label>
                <input class="form-control" type="text" id="alt" name="alt">
            </div>
            
            <div class="form-group mb-4">
                <label class="required" for="image">Image:</label>
                <input class="form-control" type="file" name="image" id="image" required>
            </div>

            <div class="d-flex justify-content-between">
                <a href="<?= APP_URL ?>bo/pages/products/index.php" class="btn btn-secondary">Retour</a>
                <button type="submit" name="submit" class="btn btn-primary">Créer</button>
            </div>
        </form>
    </div>


</body>

</html>