<?php

include_once "../../config.inc.php";
include_once APP_PATH . "helpers/rand_color.php";

function getSalesByDay($date_start = null, $date_end = null)
{
    $dbh = db_connect();

    $sql = "SELECT DATE(order_date) AS day,
    COUNT(*) AS nbSales
    FROM `order`";

    $sql .= " WHERE 1 = 1";

    if ($date_start) $sql .= " AND order_date >= :date_start";
    if ($date_end) $sql .= " AND order_date <= :date_end";

    $sql .= " GROUP BY day ORDER BY day DESC";

    try {
        $sth = $dbh->prepare($sql);

        if ($date_start)  $sth->bindParam(':date_start', $date_start, PDO::PARAM_STR);
        if ($date_end)   $sth->bindParam(':date_end', $date_end, PDO::PARAM_STR);

        $sth->execute();

        $rows = $sth->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Erreur lors de la requête SQL : " . $e->getMessage());
    }

    return $rows;
}

function getOrderCountByCategories($date_start = null, $date_end = null)
{
    $dbh = db_connect();

    $sql = "SELECT c.slug AS category_slug, c.libelle AS category_name, COUNT(op.order_id) AS order_nb, c.color AS color
    FROM category c 
    LEFT JOIN product_category pc ON c.slug = pc.category_slug
    LEFT JOIN product p ON pc.product_slug = p.slug
    LEFT JOIN order_product op ON p.slug = op.product_slug
    LEFT JOIN `order` o ON op.order_id = o.order_id";

    $sql .= " WHERE 1 = 1";

    if ($date_start) $sql .= " AND o.order_date >= :date_start";
    if ($date_end) $sql .= " AND o.order_date <= :date_end";

    $sql .= " GROUP BY c.slug ORDER BY c.sort_order;";

    try {
        $sth = $dbh->prepare($sql);

        if ($date_start)  $sth->bindParam(':date_start', $date_start, PDO::PARAM_STR);
        if ($date_end)   $sth->bindParam(':date_end', $date_end, PDO::PARAM_STR);

        $sth->execute();

        $rows = $sth->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Erreur lors de la requête SQL : " . $e->getMessage());
    }

    return $rows;
}

$date_start = isset($_POST['date_start']) ? $_POST['date_start'] : null;
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
$salesByDay = getSalesByDay($date_start, $date_end);

// Graphique historique des commandes
if (count($salesByDay) > 0) {
    $maxSalesByDay = max(array_column($salesByDay, 'nbSales'));
    $minSalesByDay = min(array_column($salesByDay, 'nbSales'));
    $nbSalesByDay = count($salesByDay);
    $avgSalesByDay = round(array_sum(array_column($salesByDay, 'nbSales')) / $nbSalesByDay);

    // Write CSS style for sales-by-day-graph
    echo "<style>
    #sales-by-day-graph {
        background-image: linear-gradient(to top, ";
    for ($i = 0; $i < count($salesByDay); $i++) {
        if (($i + 1) === count($salesByDay)) {
            echo "rgba(0, 123, 255, " . ($salesByDay[$i]["nbSales"] / $maxSalesByDay) . ") " . (100 - ($i / $nbSalesByDay) * 100) . "%);"; // si c'est la derniere ligne, format: "color degre%"
        } else {
            echo "rgba(0, 123, 255, " . ($salesByDay[$i]["nbSales"] / $maxSalesByDay) . ") " . (100 - ($i / $nbSalesByDay) * 100) . "%, "; // sinon, format: "color degre%,"
        }
    }
    echo  "} </style>";


    // echo print_r($salesByDay);
}
// Graphique camembert des catégories dans les commandes
if (count($orderCountByCategories) > 0) {
    // Calc degre and percent_libelle
    $orderNbTotal = array_sum(array_column($orderCountByCategories, 'order_nb'));
    foreach ($orderCountByCategories as &$item) {
        $item['deg'] = round(($item["order_nb"] / $orderNbTotal) * 360); // convert on % on 360
        $item['percent_libelle'] = round(($item["order_nb"] / $orderNbTotal) * 100) . "%";
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
}
if (!$orderCountByCategories || !$salesByDay) {
    $info = "Aucune donnée à afficher";
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <link rel="icon" href="<?= APP_URL ?>assets/favicon-gear.ico">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="NEW VET" />
    <title>Tableau de bord - NEW VET</title>
    <link href="<?= APP_URL ?>bo/style/bootstrap.css" rel="stylesheet">
    <link href="<?= APP_URL ?>bo/style/main.css" rel="stylesheet">
</head>

<body>
    <main>
        <?php include APP_PATH . "bo/partials/header.php"; ?>

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
            <?php if (count($salesByDay) > 0) : ?>
                <section class="col-md-4">
                    <h4 class="text-center">Historique des commandes</h4>
                    <div class="my-4 d-flex justify-content-center">
                        <div id="sales-by-day-graph"></div>
                        <!-- <pre>
                            <?php
                            print_r($salesByDay);
                            ?>
                        </pre> -->
                    </div>
                    <div class="my-4 d-flex justify-content-center">
                        <div>
                            <?php if (isset($minSalesByDay)) : ?>
                                <div class="d-flex align-items-center px-3">
                                    <span class='mx-2'>Min.: <?= $minSalesByDay ?> ventes</span>
                                </div>
                            <?php endif; ?>
                            <?php if (isset($maxSalesByDay)) : ?>
                                <div class="d-flex align-items-center px-3">
                                    <span class='mx-2'>Max.: <?= $maxSalesByDay ?> ventes</span>
                                </div>
                            <?php endif; ?>
                            <?php if (isset($avgSalesByDay)) : ?>
                                <div class="d-flex align-items-center px-3">
                                    <span class='mx-2'>Moy.: <?= $avgSalesByDay ?> ventes</span>
                                </div>
                            <?php endif; ?>
                        </div>
                </section>
            <?php endif; ?>
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
                                    <span class='mx-2'><?= $item["percent_libelle"] ?></span>
                                    <span class='mx-2'><?= $item["category_name"] ?></span>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </section>
            <?php endif; ?>
        </div>
    </main>
</body>

</html>

<script>
    // Autofill date_end with the date_start value plus 1 week at the date_end input
    document.getElementById('date_start').addEventListener('change', function() {
        let date_start = new Date(this.value);
        let date_end = new Date(this.value);
        date_end.setDate(date_end.getDate() + 7);
        document.getElementById('date_end').value = date_end.toISOString().split('T')[0];
    });

    // Autofill date_start with the date_end value minus 1 week at the date_start input
    document.getElementById('date_end').addEventListener('change', function() {
        let date_end = new Date(this.value);
        let date_start = new Date(this.value);
        date_start.setDate(date_start.getDate() - 7);
        document.getElementById('date_start').value = date_start.toISOString().split('T')[0];
    });
</script>

<style>
    .piechart {
        width: 200px;
        height: 200px;
        border-radius: 50%;
        box-shadow: inset 5px 5px rgba(0, 0, 0, 0.2);
    }

    #sales-by-day-graph {
        width: 400px;
        height: 200px;
        /* ... */
    }
</style>