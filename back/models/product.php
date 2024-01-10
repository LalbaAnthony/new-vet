<?php

function getProducts($category_slug = null, $material_slug = null, $search = null, $order_by = 'created_at', $order = 'DESC', $offset = null, $per_page = 10)
{

    // TODO: ajouter les parametres category_slug et material_slug comme des tableaux
    // TODO: tester la pagination

    $dbh = db_connect();

    $sql = "SELECT product.* FROM product
    LEFT JOIN product_category ON product_category.product_slug = product.slug
    LEFT JOIN category ON product_category.category_slug = category.slug
    LEFT JOIN product_material ON product_material.product_slug = product.slug
    LEFT JOIN material ON product_material.material_slug = material.slug";
    
    // if ($category_slug) $sql .= " AND category.slug = :category_slug";
    // if ($material_slug) $sql .= " AND material.slug = :material_slug";
    
    $sql .= " WHERE 1 = 1";
    if ($search) $sql .= " AND (name LIKE :search OR description LIKE :search OR price LIKE :search OR category.libelle LIKE :search OR material.libelle LIKE :search)";
    $sql .= " ORDER BY :order_by :order";
    if ($per_page) $sql .= " LIMIT :per_page";
    if ($offset) $sql .= " OFFSET :offset";

    try {
        $sth = $dbh->prepare($sql);

        // if ($category_slug) $sth->bindValue(":category_slug", $category_slug);
        // if ($material_slug) $sth->bindValue(":material_slug", $material_slug);
        if ($search) $sth->bindValue(":search", "%$search%");
        $sth->bindValue(":order_by", $order_by);
        $sth->bindValue(":order", $order);
        if ($per_page) $sth->bindValue(":per_page", $per_page, PDO::PARAM_INT);
        if ($offset) $sth->bindValue(":offset", $offset, PDO::PARAM_INT);

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
