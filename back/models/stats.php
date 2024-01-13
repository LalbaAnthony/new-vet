<?php

function getOrderCountByCategories()
{
    $dbh = db_connect();

    $sql = "SELECT c.slug AS category_slug, c.libelle AS category_name, COUNT(op.order_id) AS ordersNb, c.color AS color
    FROM category c
    LEFT JOIN product_category pc ON c.slug = pc.category_slug
    LEFT JOIN product p ON pc.product_slug = p.slug
    LEFT JOIN order_product op ON p.slug = op.product_slug
    GROUP BY c.slug
    ORDER BY c.sort_order;";

    try {
        $sth = $dbh->prepare($sql);

        $sth->execute();

        $rows = $sth->fetchAll(PDO::FETCH_ASSOC);
        log_txt("Read order count by categories");
    } catch (PDOException $e) {
        die("Erreur lors de la requête SQL : " . $e->getMessage());
    }

    return $rows;
}
