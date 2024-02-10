<?php

function getOrderCountByCategories($date_start = null, $date_end = null)
{
    $dbh = db_connect();

    $sql = "SELECT c.slug AS category_slug, c.libelle AS category_name, COUNT(op.order_id) AS ordersNb, c.color AS color
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

function getSalesByDay($date_start = null, $date_end = null)
{
    $dbh = db_connect();

    $sql = "SELECT DATE(order_date) AS day,
    COUNT(*) AS nbSales
    FROM `order`";

    $sql .= " WHERE 1 = 1";

    if ($date_start) $sql .= " AND order_date >= :date_start";
    if ($date_end) $sql .= " AND order_date <= :date_end";

    $sql .= " GROUP BY day ORDER BY day DESC LIMIT 7;";

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
