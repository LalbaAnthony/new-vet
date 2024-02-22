<?php

include_once "../../../config.inc.php";
include_once APP_PATH . "bo/partials/header.php";
include_once APP_PATH . "/models/contact.php";

// Réception du produit à modifier
$url_id = isset($_GET['contact_id']) ? $_GET['contact_id'] : '';
$contact = getContact($url_id);

// Modification dans la base
if (isset($_POST['submit'])) {

    // Formulaire validé : on supprime l'enregistrement
    $sucess = deleteContact($_POST['contact_id']);

    // Redirection vers la liste des contacts
    header('Location:' . APP_URL . 'bo/pages/contacts/index.php?deleted=' . $sucess);
}

// Affichage
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <link rel="icon" href="<?= APP_URL ?>assets/favicon-gear.ico">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="NEW VET" />
    <title>Suppression - NEW VET</title>
    <link href="<?= APP_URL ?>bo/style/bootstrap.css" rel="stylesheet">
    <link href="<?= APP_URL ?>bo/style/main.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h2 class="mb-4">Suppression de : <?= $contact['email'] ?></h2>

        <form action="<?= $_SERVER['PHP_SELF']; ?>" method="post" class="mb-5">
            <input type="hidden" name="contact_id" id="contact_id" value="<?= $contact['contact_id']; ?>">
            <div class="form-group">
                <label for="email">Email:</label>
                <input class="form-control" type="text" id="email" name="email" disabled value="<?= $contact['email'] ?>">
            </div>

            <div class="form-group">
                <label for="subject">subject:</label>
                <input class="form-control" type="text" id="subject" name="subject" disabled value="<?= $contact['subject'] ?>">
            </div>

            <div class="form-group">
                <label for="message">message:</label>
                <input class="form-control" type="text" id="message" name="message" disabled value="<?= $contact['message'] ?>">
            </div>

            <div class="form-group">
                <label for="stock_quantity">Date:</label>
                <input class="form-control" type="text" id="date" name="date" disabled value="<?= $contact['created_at'] ?>">
            </div>
            <br>

            <div class="d-flex justify-content-between">
                <a href="<?= APP_URL ?>bo/pages/contacts/index.php" class="btn btn-secondary">Retour</a>
                <button type="submit" name="submit" class="btn btn-danger">Supprimer</button>
            </div>
        </form>
    </div>


</body>

</html>