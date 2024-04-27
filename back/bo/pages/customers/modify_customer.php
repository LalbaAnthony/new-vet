<?php

require_once "../../../config.inc.php";
include_once APP_PATH . "controllers/customer.php";

$urlId = isset($_GET['id']) ? $_GET['id'] : '';

if (empty($urlId)) {
    header('Location: ' . APP_URL . 'bo/pages/customers/index.php');
}

$customer = getCustomer($urlId);

// Retrait du mot de passe, pour des raisons de sécurité
$customer["password"] = null;

// Modification dans la base
if (isset($_POST['submit'])) {

    // Lecture du formulaire 
    $customer['customer_id'] = isset($_POST['customer_id']) ? $_POST['customer_id'] : $customer['customer_id'];
    $customer['last_name'] = isset($_POST['last_name']) ? $_POST['last_name'] : $customer['last_name'];
    $customer['first_name'] = isset($_POST['first_name']) ? $_POST['first_name'] : $customer['first_name'];
    $customer['has_validated_email'] = isset($_POST['has_validated_email']) ? (strval($_POST['has_validated_email']) == "on" ? $_POST['has_validated_email']  = 1 : $_POST['has_validated_email'] = 0) : 0; // SPOILER ALERT LES CHECKBOXS C'EST DE LA MERDE
    $customer['email'] = isset($_POST['email']) ? $_POST['email'] : $customer['email'];

    // Formulaire validé : on modifie l'enregistrement
    $sucess = updateCustomer($customer);

    // Redirection vers la liste des clients
    header('Location: ' . APP_URL . 'bo/pages/customers/index.php?updated=' . $sucess);
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

        <h2 class="mb-4">Modification de : <?= $customer['last_name'] . ' ' . $customer['first_name'] ?></h2>

        <form action="<?= $_SERVER['PHP_SELF']; ?>" method="post" class="mb-5">
            <input type="hidden" name="customer_id" id="customer_id" value="<?= $customer['customer_id']; ?>">
            <div class="form-group">
                <label class="required" for="last_name">Nom:</label>
                <input class="form-control" type="text" id="last_name" name="last_name" value="<?= $customer['last_name'] ?>" required>
            </div>

            <div class="form-group">
                <label class="required" for="first_name">Prénom:</label>
                <input class="form-control" type="text" id="first_name" name="first_name" value="<?= $customer['first_name'] ?>" required>
            </div>

            <div class="form-group">
                <label class="required" for="price">E-mail:</label>
                <input class="form-control" type="email" id="email" name="email" value="<?= $customer['email'] ?>" required>
            </div>

            <div class="form-group my-4 p-1">
                <label for="has_validated_email">E-mail validé:</label>
                <input type="checkbox" id="has_validated_email" name="has_validated_email" <?php echo $customer['has_validated_email'] === 1 ? 'checked' : '' ?>>
            </div>

            <div class="d-flex justify-content-between my-4">
                <a href="<?= APP_URL ?>bo/pages/customers/index.php" class="btn btn-secondary">Retour</a>
                <button type="submit" name="submit" class="btn btn-primary">Modifier</button>
            </div>
        </form>
    </div>

</body>

</html>