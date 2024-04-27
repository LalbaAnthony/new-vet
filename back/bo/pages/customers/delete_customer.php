<?php

require_once "../../../config.inc.php";
include_once APP_PATH . "controllers/customer.php";

$idCustomer = isset($_GET['id']) ? $_GET['id'] : '';

if (empty($idCustomer)) {
    header('Location: ' . APP_URL . 'bo/pages/customers/index.php');
}

$customer = getCustomer($idCustomer);

// Modification dans la base
if (isset($_POST['submit'])) {

    // Formulaire validé : on supprime l'enregistrement
    $sucess = putToTrashCustomer($_POST['customer_id']);

    // Redirection vers la liste des clients
    header('Location: ' . APP_URL . 'bo/pages/customers/index.php?deleted=' . $sucess);
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
    <title>Suppression - <?= APP_NAME ?></title>
    <link href="<?= APP_URL ?>bo/style/bootstrap.css" rel="stylesheet">
    <link href="<?= APP_URL ?>bo/style/main.css" rel="stylesheet">
</head>

<body>

    <?php include_once APP_PATH . "bo/partials/header.php"; ?>

    <div class="container mt-5">
        <h2 style="margin: 30vh 0">Supprimer <?= $customer['last_name'] . ' ' . $customer['first_name'] ?> ?</h2>


        <form action="<?= $_SERVER['PHP_SELF']; ?>" method="post" class="mb-5">
            <input type="hidden" name="customer_id" id="customer_id" value="<?= $customer['customer_id']; ?>">

            <div class="d-flex justify-content-between">
                <a href="<?= APP_URL ?>bo/pages/customers/index.php" class="btn btn-secondary">Retour</a>
                <button type="submit" name="submit" class="btn btn-danger">Supprimer</button>
            </div>
        </form>
    </div>

</body>

</html>