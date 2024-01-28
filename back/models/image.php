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
    $sql = "SELECT * FROM image WHERE is_deleted = 0 ORDER BY created_at DESC;";
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
    $sql = "SELECT * FROM image WHERE is_deleted = 0 AND product_slug = :product_slug ORDER BY sort_order ASC;";
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

function getFirstImagePathFromProduct($product_slug)
{
    $dbh = db_connect();
    $sql = "SELECT * FROM image WHERE is_deleted = 0 AND product_slug = :product_slug ORDER BY sort_order ASC LIMIT 1;";
    try {
        $sth = $dbh->prepare($sql);
        $sth->execute(array(":product_slug" => $product_slug));
        $image = $sth->fetch(PDO::FETCH_ASSOC);
        log_txt("Read first image of product: slug $product_slug");
    } catch (PDOException $e) {
        die("Erreur lors de la requête SQL : " . $e->getMessage());
    }

    if ($image) {
        return $image['image_path'];
    } else {
        return null;
    }
}

function insertImage($image)
{
    $dbh = db_connect();

    $sql = "INSERT INTO image (product_slug, image_path) VALUES (:product_slug, :image_path)";

    try {
        $sth = $dbh->prepare($sql);
        $sth->execute(array(":product_slug" => $image['product_slug'], ":image_path" => $image['image_path']));
        if ($sth->rowCount() > 0) {
            log_txt("Image registered in back office: slug " . $image['product_slug']);
            return true;
        } else {
            return false;
        }
    } catch (PDOException $e) {
        die("Erreur lors de la requête SQL : " . $e->getMessage());
    }
}

function updateImage($image)
{
    $dbh = db_connect();

    $sql = "UPDATE image SET product_slug = :product_slug, image_path = :image_path WHERE image_id = :image_id";

    try {
        $sth = $dbh->prepare($sql);
        $sth->execute(array(":product_slug" => $image['product_slug'], ":image_path" => $image['image_path'], ":image_id" => $image['image_id']));
        if ($sth->rowCount() > 0) {
            log_txt("Image updated in back office: slug " . $image['image_id']);
            return true;
        } else {
            return false;
        }
    } catch (PDOException $e) {
        die("Erreur lors de la requête SQL : " . $e->getMessage());
    }
}

function deleteImage($image_id)
{
    $dbh = db_connect();

    $sql = "UPDATE image SET is_deleted = 1 WHERE image_id = :image_id";

    try {
        $sth = $dbh->prepare($sql);
        $sth->execute(array(":image_id" => $image_id));
        if ($sth->rowCount() > 0) {
            log_txt("Image deleted in back office: id " . $image_id);
            return true;
        } else {
            return false;
        }
    } catch (PDOException $e) {
        die("Erreur lors de la requête SQL : " . $e->getMessage());
    }
}
