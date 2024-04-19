<?php

require_once "../../../config.inc.php";
include_once APP_PATH . "helpers/slugify.php";
include_once APP_PATH . "controllers/category.php";
 var_dump($_POST) ;
// Modification dans la base
if (isset($_POST['submit'])) {

    $category = array();

    // Lecture du formulaire
    $category['libelle'] = isset($_POST['libelle']) ? $_POST['libelle'] : null;
    $category['color'] = isset($_POST['color']) ? $_POST['color'] : null;
    $category['is_highlander'] = isset($_POST['is_highlander']) ? $_POST['is_highlander'] : null;   
    $category['is_highlander'] = isset($_POST['is_highlander']) ? (strval($_POST['is_highlander']) == "on" ? $_POST['is_highlander']  = 1 : $_POST['is_highlander']  = 0) : 0; 
    $category['sort_order'] = isset($_POST['sort_order']) ? $_POST['sort_order'] : null;
    $category['is_quick_access'] = isset($_POST['is_quick_access']) ? $_POST['is_quick_access'] : null;
    $category['images_slugs'] = isset($_POST['images_slugs']) ? $_POST['images_slugs'] : array();
    // Generate le slug
    $category['slug'] = slugify($category['libelle']);

    // Formulaire validé : on modifie l'enregistrement
    $sucess = insertCategory($category);

    // Redirection vers la liste des produits
   // header('Location: ' . APP_URL . 'bo/pages/categories/index.php?created=' . $sucess);
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

        <h2 class="mb-4">Création d'un matériau :</h2>

        <form action="<?= $_SERVER['PHP_SELF']; ?>" method="post" class="mb-5">
            <div class="form-group">
                <label class="required" for="libelle">Libelle:</label>
                <input class="form-control" type="text" id="libelle" name="libelle" required>
            </div>

            <div class="form-group">
                <label class="required" for="color">Couleur:</label>
                <input class="form-control" type="color" id="color" name="color">
            </div>

            <div class="form-group">
                <label for="sort_order">Ordre d'affichage:</label>
                <input class="form-control" type="number" id="sort_order" name="sort_order" min="1">
            </div>

            <div class="form-group my-4 p-1">
                <label for="is_highlander">Highlander:</label>
                <input type="checkbox" id="is_highlander" name="is_highlander">
            </div>

            <div class="form-group my-4 p-1">
                <label for="is_highlander">is_quick_access ?</label>
                <input type="checkbox" id="is_quick_access" name="is_quick_access">
            </div>

            <input type="checkbox" id="images_slugs" name="images_slugs" value="test" checked>
          
         

            <div class="d-flex justify-content-between my-4">
                <a href="<?= APP_URL ?>bo/pages/categories/index.php" class="btn btn-secondary">Retour</a>
                <button type="submit" name="submit" class="btn btn-primary">Créer</button>
            </div>
        </form>
    </div>
   


</body>

</html>