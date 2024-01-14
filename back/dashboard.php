<?php

include_once "config.inc.php";
include_once "models/stats.php";
include_once "helpers/rand_color.php";

$date_start = isset($date_start) ? $_POST['date_start'] : null;
$date_end = isset($_POST['date_end']) ? $_POST['date_end'] : null;

if (!$date_start && !$date_end) {
    $date_start = date("Y-m-d", strtotime("-7 days"));
    $date_end = date("Y-m-d");
} else if ($date_start > $date_end) {
    $error = "La date de début doit être inférieure à la date de fin";
    $date_start = null;
    $date_end = null;
} else if ($date_start > date("Y-m-d") || $date_end > date("Y-m-d")) {
    $error = "Les dates doivent être antérieures à aujourd'hui";
    $date_start = null;
    $date_end = null;
}

$orderCountByCategories = getOrderCountByCategories($date_start, $date_end);

if (count($orderCountByCategories) > 0) {
    // Calc degre and percentLibelle
    $nbCats = count($orderCountByCategories);
    foreach ($orderCountByCategories as &$item) {
        $item['deg'] = round(($item["ordersNb"] / $nbCats) * 360); // convert on % on 365
        $item['percentLibelle'] = round(($item["ordersNb"] / $nbCats) * 100) . "%";
        if (!$item["color"]) $item["color"] = rand_color(); // generate random color if not exist
    }

    // Write CSS style for order-count-by-cats-piechart
    echo "<style>
    #order-count-by-cats-piechart {
        background-image: conic-gradient(";

    $degDejaConstruit = 0;
    for ($i = 0; $i < count($orderCountByCategories); $i++) {
        if (($i + 1) === count($orderCountByCategories) || count($orderCountByCategories) === 1) {
            echo $orderCountByCategories[$i]["color"] . " " . intval($degDejaConstruit) . "deg" . " " . intval($degDejaConstruit + $orderCountByCategories[$i]["deg"]) . "deg);"; // si c'est la derniere ligne, ou qu'il n'y à qu'un élément, format: "color degre"
        } else if ($i === 0) {
            echo $orderCountByCategories[$i]["color"] . " " . $orderCountByCategories[$i]["deg"] . "deg"  . ", "; // si c'est la permiere ligne, format: "color degre,"
        } else {
            echo $orderCountByCategories[$i]["color"] . " " . intval($degDejaConstruit) . "deg" . " " . intval($degDejaConstruit + $orderCountByCategories[$i]["deg"]) . "deg" . ","; // sinon, format: "color degredebut degrefin,"
        }
        $degDejaConstruit += $orderCountByCategories[$i]["deg"];
    }

    echo  "} </style>";

    // echo print_r($orderCountByCategories);
} else {
    $info = "Aucune commande n'a été passée sur la période sélectionnée";
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <link rel="icon" href="assets/favicon.ico">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="NEW VET" />
    <title>Tableau de bord - NEW VET</title>
    <link href="css/style.css" rel="stylesheet">
    <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js'></script>
</head>

<body>
    <main>
        <?php include "partials/header.php"; ?>

        <div>
            <!-- Infos & Alerts -->
            <?php if (isset($info)) : ?>
                <div class="alert alert-info" role="alert">
                    <?= $info ?>
                </div>
            <?php endif; ?>
            <?php if (isset($error)) : ?>
                <div class="alert alert-danger" role="alert">
                    <?= $error ?>
                </div>
            <?php endif; ?>

            <!-- Filters -->
            <form action="<?= $_SERVER['PHP_SELF'] ?>" method="POST">
                <div class="d-flex justify-content-center my-4 align-items-center">
                    <div class="mx-2">
                        <label for="date_start">Du</label>
                        <input type="date" name="date_start" id="date_start" value="<?= $date_start ?>">
                    </div>
                    <div class="mx-2">
                        <label for="date_end">au</label>
                        <input type="date" name="date_end" id="date_end" value="<?= $date_end ?>">
                    </div>
                    <div class="mx-2">
                        <button type="submit" class="btn btn-primary">Filtrer</button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Charts -->
        <div class='row g-0 justify-content-center'>
            <?php if (count($orderCountByCategories) > 0) : ?>
                <section class="col-md-4">
                    <h4 class="text-center">Catégories dans les commandes</h4>
                    <div class="my-4 d-flex justify-content-center">
                        <div id="order-count-by-cats-piechart" class="piechart"></div>
                    </div>
                    <div class="my-4 d-flex justify-content-center">
                        <div>
                            <?php $orderCountByCategories = array_reverse($orderCountByCategories); ?> <!-- reverse array to display legend in the right order -->
                            <?php foreach ($orderCountByCategories as &$item) : ?>
                                <div class="d-flex align-items-center px-3">
                                    <div class='p-2 px-3 rounded' style='background: <?= $item["color"] ?>;'></div>
                                    <span class='mx-2'><?= $item["percentLibelle"] ?></span>
                                    <span class='mx-2'><?= $item["category_name"] ?></span>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </section>
            <?php endif; ?>
            <section class="col-md-4">
                <h4 class="text-center">Historique des commandes</h4>
            </section>
        </div>
    </main>
</body>

</html>

<style>
    .piechart {
        width: 200px;
        height: 200px;
        border-radius: 50%;
        box-shadow: inset 5px 5px rgba(0, 0, 0, 0.2);
    }
</style>