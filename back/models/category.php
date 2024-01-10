<?php

function getCategory($category_slug)
{
    $dbh = db_connect();
    $sql = "SELECT * FROM category WHERE slug = :category_slug;";
    try {
        $sth = $dbh->prepare($sql);
        $sth->execute(array(":category_slug" => $category_slug));
        $category = $sth->fetch(PDO::FETCH_ASSOC);
        log_txt("Read category: slug $category_slug");
    } catch (PDOException $e) {
        die("Erreur lors de la requête SQL : " . $e->getMessage());
    }

    return $category;
}

function getCategoriesFromProduct($product_slug) {
    $dbh = db_connect();
    $sql = "SELECT category.* FROM product, product_category, category 
    WHERE product.slug = :product_slug
    AND product_category.category_slug = category.slug AND product_category.product_slug = product.slug;";
    try {
        $sth = $dbh->prepare($sql);
        $sth->execute(array(":product_slug" => $product_slug));
        $categories = $sth->fetchAll(PDO::FETCH_ASSOC);
        log_txt("Read categories");
    } catch (PDOException $e) {
        die("Erreur lors de la requête SQL : " . $e->getMessage());
    }

    return $categories;
}
