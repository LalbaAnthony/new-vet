<?php

include_once "config.inc.php";

// Configuration
$target_path = APP_PATH . "uploads/";
$alowed_extensions = array("jpg", "jpeg", "png", "webp");
$max_size = 1000000; // 1 Mo

if ($_SERVER["REQUEST_METHOD"] == "POST") {

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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload d'image</title>
</head>

<body>
    <h1>Formulaire d'upload d'image</h1>

    <form action="<?= $_SERVER["PHP_SELF"] ?>" method="post" enctype="multipart/form-data">
        <input type="file" name="image" id="image" required>
        <br><br>
        <input type="submit" name="submit" value="Envoyer">
    </form>
</body>

</html>