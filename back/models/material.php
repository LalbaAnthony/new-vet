<?php

function getMaterial($material_slug)
{
    $dbh = db_connect();
    $sql = "SELECT * FROM material WHERE slug = :material_slug;";
    try {
        $sth = $dbh->prepare($sql);
        $sth->execute(array(":material_slug" => $material_slug));
        $material = $sth->fetch(PDO::FETCH_ASSOC);
        log_txt("Read material: slug $material_slug");
    } catch (PDOException $e) {
        die("Erreur lors de la requête SQL : " . $e->getMessage());
    }

    return $material;
}

function getMaterials()
{
    $dbh = db_connect();
    $sql = "SELECT * FROM material ORDER BY created_at DESC;";
    try {
        $sth = $dbh->prepare($sql);
        $sth->execute();
        $materials = $sth->fetchAll(PDO::FETCH_ASSOC);
        log_txt("Read materials");
    } catch (PDOException $e) {
        die("Erreur lors de la requête SQL : " . $e->getMessage());
    }

    return $materials;
}

function getMaterialsFromProduct($product_slug)
{
    $dbh = db_connect();
    $sql = "SELECT material.* FROM product, product_material, material 
    WHERE product.slug = :product_slug
    AND product_material.material_slug = material.slug AND product_material.product_slug = product.slug;";
    try {
        $sth = $dbh->prepare($sql);
        $sth->execute(array(":product_slug" => $product_slug));
        $materials = $sth->fetchAll(PDO::FETCH_ASSOC);
        log_txt("Read materials");
    } catch (PDOException $e) {
        die("Erreur lors de la requête SQL : " . $e->getMessage());
    }

    return $materials;
}
