<?php

function getImage($slug)
{
    $dbh = db_connect();
    $sql = "SELECT * FROM image WHERE slug = :slug;";
    try {
        $sth = $dbh->prepare($sql);
        $sth->execute(array(":slug" => $slug));
        $image = $sth->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Erreur lors de la requête SQL : " . $e->getMessage());
    }

    return $image;
}

function getImages($search = null, $sort = array(array('order' => 'ASC', 'order_by' => 'created_at')), $offset = null, $per_page = 10)
{

    $dbh = db_connect();

    $sql = "SELECT * FROM image";

    // Use WHERE 1 = 1 to be able to add conditions with AND
    $sql .= " WHERE 1 = 1";

    $sql .= " AND is_deleted = 0";

    // Filter by search
    if ($search) {
        $sql .= " AND (
            name LIKE :search OR 
            slug LIKE :search OR 
            alt LIKE :search OR
            SOUNDEX(name) = SOUNDEX(:search) OR
            SOUNDEX(slug) = SOUNDEX(:search) OR
            SOUNDEX(alt) = SOUNDEX(:search)
        )";
    }

    // Sort
    if ($sort) {
        $sql .= " ORDER BY ";
        foreach ($sort as $key => $value) {
            $sql .= "COALESCE(" . $value['order_by'] . ", 9999999) " . strtoupper($value['order']); // COALESCE to avoid NULL values
            if ($key < count($sort) - 1) $sql .= ", ";
        }
    }

    // Limit and offset
    if ($per_page) $sql .= " LIMIT :per_page";
    if ($offset) $sql .= " OFFSET :offset";

    try {
        $sth = $dbh->prepare($sql);

        // Bind others values
        if ($search) $sth->bindValue(":search", "%$search%");
        if ($per_page) $sth->bindValue(":per_page", $per_page, PDO::PARAM_INT);
        if ($offset) $sth->bindValue(":offset", $offset, PDO::PARAM_INT);

        $sth->execute();

        $images = $sth->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Erreur lors de la requête SQL : " . $e->getMessage());
    }

    return $images;
}

function getImagesCount($search = null)
{
    $dbh = db_connect();

    $sql = "SELECT COUNT(*) FROM image WHERE 1 = 1 AND is_deleted = 0";

    // Filter by search
    if ($search) {
        $sql .= " AND (
            name LIKE :search OR 
            slug LIKE :search OR 
            alt LIKE :search OR
            SOUNDEX(name) = SOUNDEX(:search) OR
            SOUNDEX(slug) = SOUNDEX(:search) OR
            SOUNDEX(alt) = SOUNDEX(:search)
        )";
    }

    try {
        $sth = $dbh->prepare($sql);

        // Bind others values
        if ($search) $sth->bindValue(":search", "%$search%");

        $sth->execute();

        $count = $sth->fetchColumn();
    } catch (PDOException $e) {
        die("Erreur lors de la requête SQL : " . $e->getMessage());
    }

    return $count;
}

function getImagesFromProduct($product_slug)
{
    $dbh = db_connect();
    $sql = "SELECT * FROM image, product_image 
    WHERE image.slug = product_image.image_slug 
    AND product_image.product_slug = :product_slug
    AND image.is_deleted = 0 
    ORDER BY product_image.sort_order ASC;";
    try {
        $sth = $dbh->prepare($sql);
        $sth->execute(array(":product_slug" => $product_slug));
        $images = $sth->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Erreur lors de la requête SQL : " . $e->getMessage());
    }

    return $images;
}

function getFirstImagePathFromProduct($product_slug)
{
    $dbh = db_connect();
    $sql = "SELECT * FROM image, product_image 
    WHERE image.slug = product_image.image_slug
    AND product_image.product_slug = :product_slug
    AND image.is_deleted = 0 
    ORDER BY sort_order ASC
    LIMIT 1;";
    try {
        $sth = $dbh->prepare($sql);
        $sth->execute(array(":product_slug" => $product_slug));
        $image = $sth->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Erreur lors de la requête SQL : " . $e->getMessage());
    }

    if ($image) {
        return $image['path'];
    } else {
        return null;
    }
}

function insertImage($image)
{
    $dbh = db_connect();
    $sql = "INSERT INTO image (slug, name, alt, path, weight, extention) VALUES (:slug, :name, :alt, :path, :weight, :extention);";
    try {
        $sth = $dbh->prepare($sql);
        $sth->execute(array(":slug" => $image["slug"], ":name" => $image["name"], ":alt" => $image["alt"], ":path" => $image["path"], ":weight" => $image["weight"], ":extention" => $image["extention"]));
        log_txt("Image created in back office: id " . $dbh->lastInsertId());
        return $dbh->lastInsertId();
    } catch (PDOException $e) {
        die("Erreur lors de la requête SQL : " . $e->getMessage());
    }
}

function updateImage($image)
{
    $dbh = db_connect();
    $sql = "UPDATE image SET name = :name, alt = :alt, path = :path, weight = :weight, extention = :extention WHERE slug = :slug;";
    try {
        $sth = $dbh->prepare($sql);
        $sth->execute(array(":name" => $image["name"], ":alt" => $image["alt"], ":path" => $image["path"], ":weight" => $image["weight"], ":extention" => $image["extention"], ":slug" => $image["slug"]));
        if ($sth->rowCount() > 0) {
            log_txt("Image updated in back office: id " . $image["slug"]);
            return true;
        } else {
            return false;
        }
    } catch (PDOException $e) {
        die("Erreur lors de la requête SQL : " . $e->getMessage());
    }
}

function deleteImage($slug)
{
    $dbh = db_connect();

    $sql = "UPDATE image SET is_deleted = 1 WHERE slug = :slug";

    try {
        $sth = $dbh->prepare($sql);
        $sth->execute(array(":slug" => $slug));
        if ($sth->rowCount() > 0) {
            log_txt("Image deleted in back office: id " . $slug);
            return true;
        } else {
            return false;
        }
    } catch (PDOException $e) {
        die("Erreur lors de la requête SQL : " . $e->getMessage());
    }
}
