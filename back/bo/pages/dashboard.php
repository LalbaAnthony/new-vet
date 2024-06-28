<?php

require_once "../../config.inc.php";
include_once APP_PATH . "controllers/category.php";
include_once APP_PATH . "helpers/rand_color.php";
include_once APP_PATH . "helpers/fr_mindate.php";
include_once APP_PATH . "helpers/dates_between.php";
include_once APP_PATH . "helpers/diff_days.php";

function getSalesByDay($date_start = null, $date_end = null)
{
    $sql = "SELECT DATE(order_date) AS day,
    COUNT(*) AS nbSales
    FROM `order`";

    $sql .= " WHERE 1 = 1";

    if ($date_start) $sql .= " AND order_date >= :date_start";
    if ($date_end) $sql .= " AND order_date <= :date_end";

    $sql .= " GROUP BY day ORDER BY day ASC";

    $params = array();
    if ($date_start) $params[':date_start'] = $date_start;
    if ($date_end) $params[':date_end'] = $date_end;

    $result = Database::queryAll($sql, $params);

    return $result['data'];
}

function getOrderCountByCategories($date_start = null, $date_end = null)
{

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

    $params = array();
    if ($date_start) $params[':date_start'] = $date_start;
    if ($date_end) $params[':date_end'] = $date_end;

    $result = Database::queryAll($sql, $params);

    return $result['data'];
}

function getSumByCat($category_slug = null, $date = null)
{

    $sql = "SELECT 
    SUM(order_line.line_price) AS price, category.color FROM  order_line 
    INNER JOIN  product ON product.slug = order_line.product_slug 
    INNER JOIN  product_category ON product_category.product_slug = product.slug 
    INNER JOIN category ON category.slug = product_category.category_slug 
    INNER JOIN  `order` AS o ON o.order_id = order_line.order_id ";

    $sql .= " WHERE 1 = 1";

    if ($category_slug) $sql .= " AND product_category.category_slug = :category_slug";
    if ($date) $sql .= " AND DATE(o.order_date) = :date";

    $params = array();
    if ($category_slug) $params[':category_slug'] = $category_slug;
    if ($date) $params[':date'] = $date;

    $result = Database::queryAll($sql, $params);

    return $result['data'];
}

$error = null;
$date_start = isset($_POST['date_start']) ? $_POST['date_start'] : null;
$date_end = isset($_POST['date_end']) ? $_POST['date_end'] : null;

if ($date_start && $date_end) {
    if ($date_start > $date_end) {
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
} else {
    $date_start = date("Y-m-d", strtotime("-7 days"));
    $date_end = date("Y-m-d");
}

$salesByDay = array();
$orderCountByCategories = array();
$ordersByCat = array();

if (!$error && $date_start && $date_end) {

    // Graphique de l'historique des commandes
    $salesByDay = getSalesByDay($date_start, $date_end);
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
    }

    // Camembert des catégories dans les commandes
    $orderCountByCategories = getOrderCountByCategories($date_start, $date_end);
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
    }

    // Graphique de l'historique des commandes par catégorie
    $categories = getCategories(null, false, false, null, null, array(array('order' => 'ASC', 'order_by' => 'sort_order')), null, 9999999);
    foreach (dates_between($date_start, $date_end) as $date) {
        $ordersByCat[$date] = array();
        foreach ($categories as $category) {
            $result = getSumByCat($category['slug'], $date);
            if (!empty($result)) {
                foreach ($result as $row) {
                    $ordersByCat[$date][$category['slug']] = [
                        'price' => $row['price'],
                        'color' => $row['color'] ?? '#FFFFFF'
                    ];
                }
            } else {
                $ordersByCat[$date][$category['slug']] = [
                    'price' => 0,
                    'color' => '#FFFFFF'
                ];
            }
        }
    }
}

if (count($salesByDay) === 0 && count($orderCountByCategories) === 0 && count($ordersByCat) === 0) {
    $info = "Aucune donnée à afficher";
}

// dd($salesByDay);
// dd($orderCountByCategories);
// dd($ordersByCat);

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <link rel="icon" href="<?= APP_URL ?>assets/favicon-gear.ico">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="<?= APP_NAME ?>" />
    <title>Tableau de bord - <?= APP_NAME ?></title>
    <link href="<?= APP_URL ?>bo/style/bootstrap.css" rel="stylesheet">
    <link href="<?= APP_URL ?>bo/style/main.css" rel="stylesheet">
</head>

<body>
    <main>
        <?php include APP_PATH . "bo/partials/header.php"; ?>

        <div>
            <!-- Info & Alerts -->
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
                                        <b><?= $day['nbSales'] ?></b>
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

            <?php if (count($ordersByCat) > 0) : ?>
                <section class="col-md-4">
                    <h4 class="text-center">Historique des Commandes par Catégorie</h4>
                    <div class="my-4 d-flex justify-content-center">
                        <div id="category-sales-by-day" class="chart d-flex">
                            <?php foreach ($ordersByCat as $date => $categories) : ?>
                                <div class="d-flex flex-column align-items-center mx-2">
                                    <div class="d-flex flex-column-reverse" style="height: 300px;">
                                        <?php foreach ($categories as $category => $data) : ?>
                                            <div style="height: <?= $data['price'] * 10 ?>px; background-color: <?= $data['color'] ?>; width: 15px; margin: 1px;"></div>
                                        <?php endforeach; ?>
                                    </div>
                                    <span class="date-label"><?= fr_mindate($date); ?></span>
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