<?php

function getProducts($category_slug = null, $search = null, $order_by = 'created_at', $order = 'DESC', $offset = null, $per_page = 10)
{
    $dbh = db_connect();

    $sql = "SELECT * FROM product";
    $sql .= " WHERE 1 = 1";

    if ($category_slug) $sql .= " AND category_slug = :category_slug";
    if ($search)  $sql .= " AND (name LIKE :search OR description LIKE :search OR category_slug LIKE or price LIKE :search)";
    $sql .= " ORDER BY $order_by $order";
    if ($per_page) $sql .= " LIMIT $per_page";
    if ($offset) $sql .= " OFFSET $offset";

    try {
        $sth = $dbh->prepare($sql);

        if ($category_slug) $sth->bindValue(":category_slug", $category_slug);
        if ($search) $sth->bindValue(":search", "%$search%");

        $sth->execute();

        $products = $sth->fetchAll(PDO::FETCH_ASSOC);
        log_txt("Read products");
    } catch (PDOException $e) {
        die("Erreur lors de la requête SQL : " . $e->getMessage());
    }

    return $products;
}

function getProduct($slug)
{
    $dbh = db_connect();
    $sql = "SELECT * FROM product WHERE slug = :slug;";
    try {
        $sth = $dbh->prepare($sql);
        $sth->execute(array(":slug" => $slug));
        $product = $sth->fetch(PDO::FETCH_ASSOC);
        log_txt("Read product: slug $slug");
    } catch (PDOException $e) {
        die("Erreur lors de la requête SQL : " . $e->getMessage());
    }

    return $product;
}

function deleteProduct($slug)
{
    $dbh = db_connect();
    $sql = "DELETE FROM product WHERE slug = :slug;";
    try {
        $sth = $dbh->prepare($sql);
        $sth->execute(array(":slug" => $slug));
        log_txt("Product deleted: slug $slug");
    } catch (PDOException $e) {
        die("Erreur lors de la requête SQL : " . $e->getMessage());
    }
}

function getImages($product_slug)
{
    $dbh = db_connect();
    $sql = "SELECT * FROM image WHERE product_slug = :product_slug ORDER BY created_at DESC;";
    try {
        $sth = $dbh->prepare($sql);
        $sth->execute(array(":product_slug" => $product_slug));
        $images = $sth->fetchAll(PDO::FETCH_ASSOC);
        log_txt("Read images of product: slug $product_slug");
    } catch (PDOException $e) {
        die("Erreur lors de la requête SQL : " . $e->getMessage());
    }

    return $images;
}
