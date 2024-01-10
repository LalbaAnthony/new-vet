<?php

include_once "config.inc.php";

$login = isset($_POST['login']) ? $_POST['login'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';
$passwordConfirm = isset($_POST['passwordConfirm']) ? $_POST['passwordConfirm'] : '';

if ($login && $password && $passwordConfirm) {

    if ($password != $passwordConfirm) $error = "Les mots de passe ne correspondent pas";

    $dbh = db_connect();

    $sql = "INSERT INTO admin (login, password) VALUES (:login, :password)";

    try {
        $sth = $dbh->prepare($sql);
        $sth->execute(array(":login" => $login, ":password" => $password));
        if ($sth->rowCount() > 0) {
            log_txt("User registered in back office: login $login");
            header('Location: login.php');
        } else {
            $error = "Erreur lors de l'inscription";
        }
    } catch (PDOException $e) {
        die("Erreur lors de la requête SQL : " . $e->getMessage());
    }
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <link rel="icon" href="assets/favicon.ico">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Site de vente de vêtement pour femme." />
    <meta name="author" content="LALBA Anthony et SIREYJOL Victor" />
    <title>Inscription - NEW VET</title>
    <link href="css/style.css" rel="stylesheet">
    <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js'></script>
</head>


<body>

    <main>
        <div class="container">
            <div class="row justify-content-center align-items-center vh-100">
                <div class="col-md-4">
                    <form action="<?= $_SERVER['PHP_SELF'] ?>" method="POST">
                        <h2 class="text-center mb-4">S'inscrire</h2>
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

                        <button type="submit" class="btn btn-primary btn-block">Se créer un compte</button>
                        <button type="button" class="btn btn-secondary btn-block" onclick="window.location.href='login.php'">Se connecter</button>
                    </form>
                </div>
            </div>
        </div>
    </main>
</body>