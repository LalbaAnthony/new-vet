<?php

function getImage($image_id)
{
    $dbh = db_connect();
    $sql = "SELECT * FROM image WHERE image_id = :image_id;";
    try {
        $sth = $dbh->prepare($sql);
        $sth->execute(array(":image_id" => $image_id));
        $image = $sth->fetch(PDO::FETCH_ASSOC);
        log_txt("Read image: slug $image_id");
    } catch (PDOException $e) {
        die("Erreur lors de la requête SQL : " . $e->getMessage());
    }

    return $image;
}

function getImages()
{
    $dbh = db_connect();
    $sql = "SELECT * FROM image ORDER BY created_at DESC;";
    try {
        $sth = $dbh->prepare($sql);
        $sth->execute();
        $images = $sth->fetchAll(PDO::FETCH_ASSOC);
        log_txt("Read images");
    } catch (PDOException $e) {
        die("Erreur lors de la requête SQL : " . $e->getMessage());
    }

    return $images;
}

function getImagesFromProduct($product_slug)
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
