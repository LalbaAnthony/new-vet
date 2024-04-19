<?php

require_once "../../../config.inc.php";
include_once APP_PATH . "controllers/customer.php";



// Modification dans la base
if (isset($_POST['submit'])) {

    $customer = array();

    // Lecture du formulaire
    $customer['first_name'] = isset($_POST['first_name']) ? $_POST['first_name'] : null;
    $customer['last_name'] = isset($_POST['last_name']) ? $_POST['last_name'] : null;
    $customer['email'] = isset($_POST['email']) ? $_POST['email'] : null;
    $customer['password'] = isset($_POST['password']) ? $_POST['password'] : null;


    // Formulaire validé : on modifie l'enregistrement
    $sucesscustomer = insertcustomer($customer);



    $sucess = $sucesscustomer;

    // Redirection vers la liste des clients
     header('Location: ' . APP_URL . 'bo/pages/customers/index.php?created=' . $sucess);
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

        <h2 class="mb-4">Création d'un client :</h2>

        <form action="<?= $_SERVER['PHP_SELF']; ?>" method="post" class="mb-5">
            <div class="form-group">
                <label class="required" for="first_name">Prenom:</label>
                <input class="form-control" type="text" id="first_name" name="first_name" required>
            </div>

            <div class="form-group">
                <label class="required" for="last_name">Nom:</label>
                <input class="form-control" type="text" id="last_name" name="last_name" required>
            </div>


           <div class="form-group">
                <label class="required" for="email">Email:</label>
                <input class="form-control" type="email" id="email" name="email" required>
            </div>
        

            <div class="form-group my-4 p-1">
                <label for="has_validated_email">Mot de Passe:</label>
                <input type="password" id="password" name="password"  required>
            </div>

       

            <div class="d-flex justify-content-between my-4">
                <a href="<?= APP_URL ?>bo/pages/products/index.php" class="btn btn-secondary">Retour</a>
                <button type="submit" name="submit" class="btn btn-primary">Créer</button>
            </div>
        </form>
    </div>


</body>

</html>
