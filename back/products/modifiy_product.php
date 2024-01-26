<?php

include_once "../config.inc.php";
include_once "../partials/header.php";
include_once "../models/product.php";

// Connexion à la base
$dbh = db_connect();

// Récupère l'ID passé dans l'URL 
$slug = isset($_GET['slug']) ? $_GET['slug'] : '';



$submit = isset($_POST['submit']);

// Modification dans la base
if ($submit) {

    // Lecture du formulaire 
    $slug = isset($_POST['slug']) ? $_POST['slug'] : '';
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $description = isset($_POST['description']) ? $_POST['description'] : '';
    $price = isset($_POST['price']) ? $_POST['price'] : '';
    $quantity = isset($_POST['quantity']) ? $_POST['quantity'] : '';

    // Formulaire validé : on modifie l'enregistrement
    $sql = "UPDATE product SET name = :name , description = :description ,  price = :price , stock_quantity = :quantity  WHERE slug=:slug";
    $params = array(
        ":slug" => $slug,
        ":name" => $name,
        ":description" => $description,
        ":price" => $price,
        ":quantity" => $quantity,
    );
    try {

        $sth = $dbh->prepare($sql);
        $sth->execute($params);
    } catch (PDOException $e) {
        die("<p>Erreur lors de la requête SQL : " . $e->getMessage() . "</p>");
    }
} else {
    // Formulaire non encore validé : on affiche l'enregistrement
    $product = getProduct($slug);
    if ($product) {
        $name = isset($product['name']) ? $product['name'] : '';
        $quantity = isset($product['stock_quantity']) ? $product['stock_quantity'] : '';
        $price = isset($product['price']) ? $product['price'] : '';
        $description = isset($product['description']) ? $product['description'] : '';
    }
}

// Affichage
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <link rel="icon" href="assets/favicon.ico">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="NEW VET" />
    <title>Tableau de bord - NEW VET</title>
    <link href="css/bootstrap.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h2 class="mb-4">Modifier Produit - <?= $name ?></h2>

        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="mb-5">
            <div class="form-group">
                <label for="name">Name:</label>
                <input class="form-control" type="text" id="name" name="name" value="<?= $name ?>">
            </div>

            <div class="form-group">
                <label for="description">Description:</label>
                <input class="form-control" type="text" id="description" name="description" value="<?= $description ?>">
            </div>

            <div class="form-group">
                <label for="price">Price:</label>
                <input class="form-control" type="text" id="price" name="price" value="<?= $price ?>">
            </div>

            <div class="form-group">
                <label for="quantity">Quantity:</label>
                <input class="form-control" type="text" id="quantity" name="quantity" value="<?= $quantity ?>">
            </div>

            <input type="hidden" name="slug" id="slug" value="<?= $slug; ?>">

            <button type="submit" name="submit" class="btn btn-primary">Envoyer</button>
        </form>
    </div>


</body>

</html>