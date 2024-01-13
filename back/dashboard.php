<?php

include_once "config.inc.php";
include_once "models/stats.php";
include_once "helpers/rand_color.php";

$orderCountByCategories = getOrderCountByCategories();

// Calc degre and percentLibelle
$nbCats = count($orderCountByCategories);
foreach ($orderCountByCategories as &$item) {
    $item['deg'] = round(($item["ordersNb"] / $nbCats) * 360); // convert on % on 365
    $item['percentLibelle'] = round(($item["ordersNb"] / $nbCats) * 100) . "%";
    if (!$item["color"]) $item["color"] = rand_color(); // generate random color if not exist
}


// Write CSS style for categories-per-order-piechart
echo "<style>
.categories-per-order-piechart {
    width: 200px;
    height: 200px;
    border-radius: 50%;
    background-image: conic-gradient(";

$degDejaConstruit = 0;
for ($i = 0; $i < count($orderCountByCategories); $i++) {
    if ($i === 0) {
        echo $orderCountByCategories[$i]["color"] . " " . $orderCountByCategories[$i]["deg"] . "deg"  . ", "; // si c'est la permiere ligne, format: "color degre,"
    } elseif (($i + 1) === count($orderCountByCategories)) {
        echo $orderCountByCategories[$i]["color"] . " " . intval($degDejaConstruit) . "deg" . " " . intval($degDejaConstruit + $orderCountByCategories[$i]["deg"]) . "deg);"; // si c'est la derniere ligne, format: "color degre"
    } else {
        echo $orderCountByCategories[$i]["color"] . " " . intval($degDejaConstruit) . "deg" . " " . intval($degDejaConstruit + $orderCountByCategories[$i]["deg"]) . "deg" . ","; // sinon, format: "color degredebut degrefin,"
    }
    $degDejaConstruit += $orderCountByCategories[$i]["deg"];
}

echo  "} </style>";

// echo print_r($orderCountByCategories);
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

        <div class='row gx-4 gx-lg-5 justify-content-center'>
            <section class="col-md-4 mt-5">
                <h4 class="text-center">Répartition des catégories dans les comandes</h4>
                <div class="my-4 d-flex justify-content-center">
                    <div class="categories-per-order-piechart"></div>
                </div>
                <div class="my-4 d-flex justify-content-center">
                    <div class="categories-per-order-piechart-legend">
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
            <section class="col-md-4 mt-5">
                <h4 class="text-center">Historique des commandes</h4>

            </section>
        </div>
    </main>
</body>

</html>