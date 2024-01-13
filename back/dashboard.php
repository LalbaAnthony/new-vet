<?php

include_once "config.inc.php";
include_once "models/stats.php";
include_once "helpers/rand_color.php";

$orderCountByCategories = getOrderCountByCategories();

$nbCats = count($orderCountByCategories);

foreach ($orderCountByCategories as &$item) {
    $item['deg'] = ($item["ordersNb"] / $nbCats) * 365; // convert on % on 365
    $item['percentageLibelle'] = round(($item["ordersNb"] / $nbCats) * 100) . "%";
    $item['color'] = $item["color"] ? $item["color"] : rand_color(); // generate random color if not exist
}

print_r($orderCountByCategories);

echo "<style>
    .piechart {
      width: 200px;
      height: 200px;
      border-radius: 50%;
      background-image: conic-gradient(";
foreach ($orderCountByCategories as $item) {
    echo $item['color'] . " " . $item['deg'] . "deg, ";
}
echo $orderCountByCategories[0]['color'] . " 0deg);";
echo "    }
    </style>";

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
        <div class="container">
            <div class="mt-2 d-flex justify-content-center">
                <div class="piechart"></div>
            </div>
        </div>
    </main>
</body>

</html>