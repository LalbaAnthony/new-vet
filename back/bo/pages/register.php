<?php

include_once "../../config.inc.php";
include_once APP_PATH . "helpers/password_strength.php";
include_once APP_PATH . "models/admin.php";

$login = isset($_POST['login']) ? trim($_POST['login']) : '';
$password = isset($_POST['password']) ? trim($_POST['password']) : '';
$passwordConfirm = isset($_POST['passwordConfirm']) ? trim($_POST['passwordConfirm']) : '';

if ($login && $password && $passwordConfirm) {

    if ($password != $passwordConfirm) {
        $error = "Les mots de passe ne correspondent pas";
    } else {
        if (strlen($login) < 3 || strlen($login) > 20) {
            $error = "La longueur du login doit être contenu entre 3 et 20 caractères";
        } else {
            if (password_strength($password) < 5) {
                $error = "Le mot de passe doit contenir au moins 8 caractères, une majuscule, une minuscule, un chiffre et un caractère spécial";
            } else {
                $admin = getAdmin($login);
                if ($admin && $admin['login'] == $login) {
                    $error = "Ce login est déjà utilisé";
                } else {
                    if (insertAdmin($login, $password)) {
                        $success = "Inscription réussie";
                        header("Location: " . APP_URL . "bo/pages/login.php");
                    } else {
                        $error = "Erreur lors de l'inscription";
                    }
                }
            }
        }
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
    <title>Inscription - NEW VET</title>
    <link href="<?= APP_URL ?>bo/style/bootstrap.css" rel="stylesheet">
    <link href="<?= APP_URL ?>bo/style/main.css" rel="stylesheet">
</head>

<body>

    <main>
        <div class="container">
            <div class="row justify-content-center align-items-center vh-100">
                <div class="col-md-4">
                    <form action="<?= $_SERVER['PHP_SELF'] ?>" method="POST">
                        <h2 class="text-center mb-4">S'inscrire</h2>
                        <?php if (isset($success)) : ?>
                            <div class="alert alert-success" role="alert">
                                <?= $success ?>
                            </div>
                        <?php endif; ?>
                        <?php if (isset($error)) : ?>
                            <div class="alert alert-danger" role="alert">
                                <?= $error ?>
                            </div>
                        <?php endif; ?>

                        <div class="form-group">
                            <label for="login">Login:</label>
                            <input type="text" class="form-control" name="login" id="login" placeholder="Entrez votre login" required>
                        </div>
                        <br>

                        <div class="form-group">
                            <label for="password">Mot de passe:</label>
                            <input type="password" class="form-control" name="password" id="password" placeholder="Entrez votre mot de passe" required>
                        </div>
                        <br>
                        <div class="form-group">
                            <label for="password">Confimez votre mot de passe:</label>
                            <input type="password" class="form-control" name="passwordConfirm" id="passwordConfirm" placeholder="Confirmez votre mot de passe" required>
                        </div>
                        <br>

                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn btn-primary btn-block">Se créer un compte</button>
                            <button type="button" class="btn btn-secondary btn-block" onclick="window.location.href='<?= APP_URL ?>bo/pages/login.php'">Se connecter</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
</body>