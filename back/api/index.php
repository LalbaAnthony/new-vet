<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <link rel="icon" href="../assets/favicon.ico">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Site de vente de vêtement pour femme." />
    <meta name="author" content="LALBA Anthony et SIREYJOL Victor" />
    <title>NEW VET - Back-office</title>
</head>

<body>
    <h1>Error 404: cette route de l'API n'existe pas.</h1>
    <h4>Listes des routes disponibles:</h4>
    <ul>
        <?php
        $files = scandir("."); // . = dossier courant
        $files = array_slice($files, 2); // on retire les deux premiers éléments du tableau (.) et (..)
        foreach ($files as $file) {
            echo "<li><a href='$file'>$file</a></li>";
        }
        ?>
    </ul>

</body>

</html>