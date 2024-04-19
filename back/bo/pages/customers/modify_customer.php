<?php

require_once "../../../config.inc.php";
include_once APP_PATH . "controllers/customer.php";

$CustomerID = isset($_GET['id']) ? $_GET['id'] : '';

$customer = getCustomer($CustomerID);


// Modification dans la base
if (isset($_POST['submit'])) {

    // Lecture du formulaire 
    $customer['customer_id'] = isset($_POST['customer_id']) ? $_POST['customer_id'] : $customer['customer_id'];
    $customer['last_name'] = isset($_POST['last_name']) ? $_POST['last_name'] : $customer['last_name'];
    $customer['first_name'] = isset($_POST['first_name']) ? $_POST['first_name'] : $customer['first_name'];
    $customer['email'] = isset($_POST['email']) ? $_POST['email'] : $customer['email'];
    $customer['password'] = isset($_POST['password']) ? $_POST['password'] : null;
  
    // Formulaire validé : on modifie l'enregistrement
    $sucesscustomer = updateCustomer($customer);


    $sucess = $sucesscustomer;

    // Redirection vers la liste des clients
    header('Location: ' . APP_URL . 'bo/pages/customers/index.php?updated=' . $sucess);
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
    <title>Modification - <?= APP_NAME ?></title>
    <link href="<?= APP_URL ?>bo/style/bootstrap.css" rel="stylesheet">
    <link href="<?= APP_URL ?>bo/style/main.css" rel="stylesheet">
</head>

<body>

    <?php include_once APP_PATH . "bo/partials/header.php"; ?>

    <div class="container mt-5">

        <?php if ($customer["is_deleted"] == 1) : ?>
            <div class="alert alert-danger" role="alert">
                Attention, ce client a été supprimé !
            </div>
        <?php endif; ?>

        <h2 class="mb-4">Modification de : <?= $customer['last_name'].' '. $customer['first_name'] ?></h2>

        <form action="<?= $_SERVER['PHP_SELF']; ?>" method="post" class="mb-5">
            <input type="hidden" name="customer_id" id="customer_id" value="<?= $customer['customer_id']; ?>">
            <div class="form-group">
                <label class="required" for="last_name">Nom:</label>
                <input class="form-control" type="text" id="last_name" name="last_name" value="<?= $customer['last_name'] ?>" required>
            </div>

            <div class="form-group">
                <label class="required" for="first_name">Prenom:</label>
                <input class="form-control" type="text" id="first_name" name="first_name" value="<?= $customer['first_name'] ?>" required>
            </div>

            <div class="form-group">
                <label class="required" for="price">Email:</label>
                <input class="form-control" type="email" id="email" name="email" value="<?= $customer['email'] ?>" required>
            </div>

            <div class="form-group">
                <label for="sort_order">Password:</label>
                <input class="form-control" type="password" id="password" name="password" value="<?= $customer['password'] ?>" >
            </div>

          
            <div class="d-flex justify-content-between">
                <a href="<?= APP_URL ?>bo/pages/customers/index.php" class="btn btn-secondary">Retour</a>
                <button type="submit" name="submit" class="btn btn-primary">Modifier</button>
            </div>
        </form>
    </div>


</body>

</html>

?>