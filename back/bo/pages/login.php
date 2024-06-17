<?php

require_once "../../config.inc.php";
include_once APP_PATH . "controllers/admin.php";

$login = isset($_POST['login']) ? trim($_POST['login']) : '';
$password = isset($_POST['password']) ? trim($_POST['password']) : '';

if ($login && $password) {

    $admin = getAdmin($login);

    if ($admin && $admin['login'] == $login) {
        if (password_verify($password, $admin['password'])) {
            if ($admin['has_access'] == 1) {
                $_SESSION['admin'] = $admin;
                $success = "Connexion réussie";
                autoUpdateLastLoginAdmin($admin['admin_id']);
                log_txt("User logged in back office: login $login");
                header('Location: ' . APP_URL . 'bo/pages/index.php');
            } else {
                $error = "Vous n'avez pas accès au back office";
                log_txt("User tried to log in back office but has no access: login $login");
            }
        } else {
            $error = "Mot de passe incorrect";
            log_txt("User tried to log in back office but password is incorrect: login $login");
        }
    } else {
        $error = "Login incorrect";
        log_txt("User tried to log in back office but login is incorrect: login $login");
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
    <title>Connexion - <?= APP_NAME ?></title>
    <link href="<?= APP_URL ?>bo/style/bootstrap.css" rel="stylesheet">
    <link href="<?= APP_URL ?>bo/style/main.css" rel="stylesheet">
</head>

<body>
    <main>
        <div class="container">
            <div class="row justify-content-center align-items-center vh-100">
                <div class="col-md-4">
                    <form action="<?= $_SERVER['PHP_SELF'] ?>" method="POST">
                        <h2 class="text-center mb-4">Connexion</h2>
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

                        <div class="form-group my-4">
                            <label for="login">Login:</label>
                            <input type="text" class="form-control" name="login" id="login" placeholder="Entrez votre login" required value="<?= $login ?>">
                        </div>
                        <br>

                        <div class="form-group my-4">
                            <label for="password">Mot de passe:</label>
                            <input type="password" class="form-control" name="password" id="password" placeholder="Entrez votre mot de passe" required value="<?= $password ?>">
                        </div>
                        <br>

                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn btn-primary btn-block">Se connecter</button>
                            <button type="button" class="btn btn-secondary btn-block" onclick="window.location.href='<?= APP_URL ?>bo/pages/register.php'">Se créer un compte</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
</body>