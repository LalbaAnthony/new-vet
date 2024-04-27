<?php

require_once "../../../config.inc.php";
include_once APP_PATH . "controllers/customer.php";
include_once APP_PATH . "helpers/password_strength.php";

$error = null;

// Insertion dans la base
if (isset($_POST['submit'])) {

    $customer = array();

    // Lecture du formulaire 
    $customer['last_name'] = isset($_POST['last_name']) ? $_POST['last_name'] : $customer['last_name'];
    $customer['first_name'] = isset($_POST['first_name']) ? $_POST['first_name'] : $customer['first_name'];
    $customer['has_validated_email'] = isset($_POST['has_validated_email']) ? (strval($_POST['has_validated_email']) == "on" ? $_POST['has_validated_email']  = 1 : $_POST['has_validated_email'] = 0) : 0; // SPOILER ALERT LES CHECKBOXS C'EST DE LA MERDE
    $customer['email'] = isset($_POST['email']) ? $_POST['email'] : $customer['email'];
    $customer['password'] = isset($_POST['password']) ? $_POST['password'] : $customer['password'];

    if (password_strength($customer['password']) < 5) {
        $error = "Le mot de passe doit contenir au moins 8 caractères, une majuscule, une minuscule, un chiffre et un caractère spécial";
    }

    if (strlen($customer['last_name']) < 3 || strlen($customer['last_name']) > 20) {
        $error = "La longueur du nom doit être contenue entre 3 et 20 caractères";
    }

    if (strlen($customer['first_name']) < 3 || strlen($customer['first_name']) > 20) {
        $error = "La longueur du prénom doit être contenue entre 3 et 20 caractères";
    }

    if (strlen($customer['email']) < 3 || strlen($customer['email']) > 50) {
        $error = "La longueur de l'email doit être contenue entre 3 et 50 caractères";
    }

    // Check if user exists
    if (!$error) {
        $another_customer = getCustomerByEmail($customer['email']);
        if ($another_customer) {
            $error = "Cet utilisateur existe déjà";
        }
    }

    if (!$error) {
        // Hash du mot de passe
        $customer['password'] = password_hash($customer['password'], PASSWORD_DEFAULT);

        // Formulaire validé : on modifie l'enregistrement
        $sucess = insertCustomer($customer);

        // Redirection vers la liste des clients
        header('Location: ' . APP_URL . 'bo/pages/customers/index.php?created=' . $sucess);
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
    <script src="<?= APP_URL ?>bo/script/autosave.js"></script>
</head>

<body>

    <?php include_once APP_PATH . "bo/partials/header.php"; ?>

    <div class="container mt-5">
        <?php include_once APP_PATH . "bo/partials/alert_message.php"; ?>

        <?php if ($error) : ?>
            <div class="alert alert-danger" role="alert">
                <?= $error; ?>
            </div>
        <?php endif; ?>

        <h2 class="mb-4">Création d'un client :</h2>

        <form action="<?= $_SERVER['PHP_SELF']; ?>" method="post" class="mb-5">
            <div class="form-group">
                <label class="required" for="last_name">Nom:</label>
                <input class="form-control" type="text" id="last_name" name="last_name" required>
            </div>

            <div class="form-group">
                <label class="required" for="first_name">Prénom:</label>
                <input class="form-control" type="text" id="first_name" name="first_name" required>
            </div>

            <div class="form-group">
                <label class="required" for="price">E-mail:</label>
                <input class="form-control" type="email" id="email" name="email" required>
            </div>

            <div class="form-group my-4 p-1">
                <label for="has_validated_email">E-mail validé:</label>
                <input type="checkbox" id="has_validated_email" name="has_validated_email">
            </div>

            <div class="form-group">
                <label class="required" for="password">Mot de passe:</label>
                <input class="form-control" type="password" id="password" name="password" minlength="8" required>
            </div>

            <div class="d-flex justify-content-between my-4">
                <a href="<?= APP_URL ?>bo/pages/customers/index.php" class="btn btn-secondary">Retour</a>
                <button type="submit" name="submit" class="btn btn-primary">Créer</button>
            </div>
        </form>
    </div>

</body>

</html>