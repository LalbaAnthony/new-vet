<?php

include_once "../../config.inc.php";
include_once APP_PATH . "models/category.php";
include_once APP_PATH . "helpers/rand_color.php";
include_once APP_PATH . "helpers/fr_mindate.php";
include_once APP_PATH . "helpers/dates_between.php";
include_once APP_PATH . "helpers/diff_days.php";

function getSalesByDay($date_start = null, $date_end = null)
{
    $dbh = db_connect();

    $sql = "SELECT DATE(order_date) AS day,
    COUNT(*) AS nbSales
    FROM `order`";

    $sql .= " WHERE 1 = 1";

    if ($date_start) $sql .= " AND order_date >= :date_start";
    if ($date_end) $sql .= " AND order_date <= :date_end";

    $sql .= " GROUP BY day ORDER BY day ASC";

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

function getAvgCartByCat($date_start = null, $date_end = null, $category_slug = null)
{
    $dbh = db_connect();

    // $sql = "SELECT category.slug AS category_slug, category.libelle AS category_libelle, AVG(product.price) AS avg_cart
    // FROM `order`, order_line, product, product_category, category
    // WHERE `order`.order_id = order_line.order_id
    // AND order_line.product_slug = product.slug
    // AND product.slug = product_category.product_slug
    // AND product_category.category_slug = category.slug";
    $sql = "SELECT c.slug AS category_slug, c.libelle AS category_libelle, AVG(p.price) AS avg_cart
    FROM category c
    LEFT JOIN product_category pc ON c.slug = pc.category_slug
    LEFT JOIN product p ON pc.product_slug = p.slug
    LEFT JOIN order_line ol ON p.slug = ol.product_slug
    LEFT JOIN `order` o ON ol.order_id = o.order_id";

    $sql .= " WHERE 1 = 1";

    if ($category_slug) $sql .= " AND category.slug = :category_slug";

    if ($date_start) $sql .= " AND o.order_date >= :date_start";
    if ($date_end) $sql .= " AND o.order_date <= :date_end";

    $sql .= " GROUP BY c.slug ORDER BY c.sort_order;";

    try {
        $sth = $dbh->prepare($sql);

        if ($category_slug) $sth->bindParam(':category_slug', $category_slug, PDO::PARAM_STR);
        if ($date_start) $sth->bindParam(':date_start', $date_start, PDO::PARAM_STR);
        if ($date_end) $sth->bindParam(':date_end', $date_end, PDO::PARAM_STR);

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
    LEFT JOIN order_line op ON p.slug = op.product_slug
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

$error = null;
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
} else if (diff_days($date_start, $date_end) > 7) {
    $error = "Le delta des dates ne doit pas dépasser 7 jours";
    $date_start = null;
    $date_end = null;
}

$orderCountByCategories = array();
$avgCartByCat = array();
$salesByDay = array();

if (!$error && $date_start && $date_end) {
    $orderCountByCategories = getOrderCountByCategories($date_start, $date_end);
    $categories = getCategories(null, false, false, null, null, array(array('order' => 'ASC', 'order_by' => 'sort_order')), null, 9999999);
    $salesByDay = getSalesByDay($date_start, $date_end);
}

// Graphique historique des commandes
if (count($salesByDay) > 0) {
    $nbSalesDay = count($salesByDay);
    $maxSalesByDay = max(array_column($salesByDay, 'nbSales'));
    $minSalesByDay = min(array_column($salesByDay, 'nbSales'));
    $avgSalesByDay = round(array_sum(array_column($salesByDay, 'nbSales')) / $nbSalesDay);

    // Fill missing days
    foreach (dates_between($date_start, $date_end) as $date) {
        if (!in_array($date, array_column($salesByDay, 'day'))) {
            $salesByDay[] = ['day' => $date, 'nbSales' => 0];
        }
    }

    // Compute percent
    foreach ($salesByDay as &$day) {
        $day['percent'] = round(($day['nbSales'] / $maxSalesByDay) * 100);
    }

    // Tri par date
    usort($salesByDay, function ($a, $b) {
        return strtotime($a['day']) - strtotime($b['day']);
    });

    // dd($salesByDay);
}

if (isset($categories)) {

    foreach ($categories as $category) {
        $avgCartByCat[$category['slug']] = getAvgCartByCat($date_start, $date_end);
    }

    // dd($avgCartByCat);
}

// Graphique camembert des catégories dans les commandes
if (count($orderCountByCategories) > 0) {
    // Calc degre and percent
    $orderNbTotal = array_sum(array_column($orderCountByCategories, 'order_nb'));
    foreach ($orderCountByCategories as &$item) {
        $item['deg'] = round(($item["order_nb"] / $orderNbTotal) * 360); // convert on % on 360
        $item['percent'] = round(($item["order_nb"] / $orderNbTotal) * 100);
        if (!$item["color"]) $item["color"] = rand_color(); // generate random color if not exist
    }

    // Write CSS style for order-count-by-cats-piechart
    echo "<style>
    #order-count-by-cats {
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

    // dd($orderCountByCategories);
}

if (!$orderCountByCategories && !$avgCartByCat && !$salesByDay) {
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
                        <div id="sales-by-day">
                            <?php foreach ($salesByDay as $day) : ?>
                                <div>
                                    <div class="bar" style="background: linear-gradient(0deg, #007bff <?= $day['percent'] ?>%, #fff <?= $day['percent'] ?>%);"></div>
                                    <span class="text-center">
                                        <?php if ($day['nbSales'] > 0) : ?>
                                            <b><?= $day['nbSales'] ?></b>
                                        <?php endif; ?>
                                        <br><?= fr_mindate($day['day']) ?>
                                    </span>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <div class="my-4 d-flex justify-content-center">
                        <div>
                            <?php if (isset($minSalesByDay)) : ?>
                                <div class="d-flex align-items-center px-3">
                                    <span class='mx-2'>Min.: <?= $minSalesByDay ?> ventes</span>
                                </div>
                            <?php endif; ?>
                            <?php if (isset($avgSalesByDay)) : ?>
                                <div class="d-flex align-items-center px-3">
                                    <span class='mx-2'>Moy.: <?= $avgSalesByDay ?> ventes</span>
                                </div>
                            <?php endif; ?>
                            <?php if (isset($maxSalesByDay)) : ?>
                                <div class="d-flex align-items-center px-3">
                                    <span class='mx-2'>Max.: <?= $maxSalesByDay ?> ventes</span>
                                </div>
                            <?php endif; ?>
                        </div>
                </section>
            <?php endif; ?>
            <?php if (count($orderCountByCategories) > 0) : ?>
                <section class="col-md-4">
                    <h4 class="text-center">Catégories dans les commandes</h4>
                    <div class="my-4 d-flex justify-content-center">
                        <div id="order-count-by-cats"></div>
                    </div>
                    <div class="my-4 d-flex justify-content-center">
                        <div>
                            <?php $orderCountByCategories = array_reverse($orderCountByCategories); ?> <!-- reverse array to display legend in the right order -->
                            <?php foreach ($orderCountByCategories as $item) : ?>
                                <div class="d-flex align-items-center px-3">
                                    <div class='p-2 px-3 rounded' style='background: <?= $item["color"] ?>;'></div>
                                    <span class='mx-1'><?= $item["percent"] ?>%</span>
                                    <span class='mx-1'><?= $item["category_name"] ?></span>
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
        date_end.setDate(date_end.getDate() + 6);
        document.getElementById('date_end').value = date_end.toISOString().split('T')[0];
    });

    // Autofill date_start with the date_end value minus 1 week at the date_start input
    document.getElementById('date_end').addEventListener('change', function() {
        let date_end = new Date(this.value);
        let date_start = new Date(this.value);
        date_start.setDate(date_start.getDate() - 6);
        document.getElementById('date_start').value = date_start.toISOString().split('T')[0];
    });
</script>

<style>
    #sales-by-day {
        width: 400px;
        height: 200px;
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        gap: 5px;
    }

    #sales-by-day div {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    #sales-by-day div .bar {
        height: 80%;
        width: 100%;
        background-color: #007bff;
    }

    #order-count-by-cats {
        width: 200px;
        height: 200px;
        border-radius: 50%;
    }
</style>