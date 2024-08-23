<?php

function getImage($slug)
{
    $sql = "SELECT * FROM image WHERE slug = :slug;";

    $params = array(":slug" => $slug);

    $result = Database::queryOne($sql, $params);

    return $result['data'];
}

function getImages($search = null, $sort = array(array('order' => 'ASC', 'order_by' => 'created_at')), $offset = null, $per_page = 10)
{


    $sql = "SELECT * FROM image";

    // Use WHERE 1 = 1 to be able to add conditions with AND
    $sql .= " WHERE 1 = 1";

    $sql .= " AND is_deleted = 0";

    // Filter by search
    if ($search) {
        $sql .= " AND (
            name LIKE :like_search OR 
            slug LIKE :like_search OR 
            alt LIKE :like_search OR
            SOUNDEX(name) = SOUNDEX(:soundex_search) OR
            SOUNDEX(slug) = SOUNDEX(:soundex_search) OR
            SOUNDEX(alt) = SOUNDEX(:soundex_search)
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

    $params = array();

    // Bind values
    if ($search) {
        $params[":like_search"] = "'%$search%'";
        $params[":soundex_search"] = "'$search'";
    }
    if ($per_page) $params[":per_page"] = $per_page;
    if ($offset) $params[":offset"] = $offset;

    $result = Database::queryAll($sql, $params);

    return $result['data'];
}

function getImagesCount($search = null)
{

    $sql = "SELECT COUNT(DISTINCT image.slug) as count FROM image WHERE 1 = 1 AND is_deleted = 0";

    // Filter by search
    if ($search) {
        $sql .= " AND (
            name LIKE :like_search OR 
            slug LIKE :like_search OR 
            alt LIKE :like_search OR
            SOUNDEX(name) = SOUNDEX(:soundex_search) OR
            SOUNDEX(slug) = SOUNDEX(:soundex_search) OR
            SOUNDEX(alt) = SOUNDEX(:soundex_search)
        )";
    }

    $params = array();

    // Bind values
    if ($search) {
        $params[":like_search"] = "'%$search%'";
        $params[":soundex_search"] = "'$search'";
    }

    $result = Database::queryOne($sql, $params);

    return $result['data']['count'];
}

function getImagesFromProduct($product_slug)
{
    $sql = "SELECT * FROM image, product_image 
    WHERE image.slug = product_image.image_slug 
    AND product_image.product_slug = :product_slug
    AND image.is_deleted = 0 
    ORDER BY product_image.sort_order ASC;";

    $params = array(":product_slug" => $product_slug);

    $result = Database::queryAll($sql, $params);

    return $result['data'];
}

function getFirstImagePathFromProduct($product_slug)
{
    $sql = "SELECT * FROM image, product_image 
    WHERE image.slug = product_image.image_slug
    AND product_image.product_slug = :product_slug
    AND image.is_deleted = 0 
    ORDER BY sort_order ASC
    LIMIT 1;";

    $params = array(":product_slug" => $product_slug);

    $result = Database::queryOne($sql, $params);

    if (!$result['data']) return false;

    return $result['data']['path'];
}

function insertImage($image)
{
    $sql = "INSERT INTO image (slug, name, alt, path, weight, extention) VALUES (:slug, :name, :alt, :path, :weight, :extention);";

    $result = Database::queryInsert($sql, array(":slug" => $image['slug'], ":name" => $image['name'], ":alt" => $image['alt'], ":path" => $image['path'], ":weight" => $image['weight'], ":extention" => $image['extention']));

    if ($result['success']) {
        log_txt("Image inserted in back office: id " . $result['lastInsertId']);
        return true;
    } else {
        return false;
    }
}

function updateImage($image)
{
    $sql = "UPDATE image SET ";

    if (isset($image['name'])) $sql .= " name = :name,";
    if (isset($image['alt'])) $sql .= " alt = :alt,";
    if (isset($image['path'])) $sql .= " path = :path,";
    if (isset($image['weight'])) $sql .= " weight = :weight,";
    if (isset($image['extention'])) $sql .= " extention = :extention,";
    if (isset($image['is_deleted'])) $sql .= " is_deleted = :is_deleted,";

    $sql = rtrim($sql, ",");

    $sql .= " WHERE slug = :slug;";

    $params = array();

    if (isset($image['slug'])) $params[":slug"] = $image['slug'];
    if (isset($image['name'])) $params[":name"] = $image['name'];
    if (isset($image['alt'])) $params[":alt"] = $image['alt'];
    if (isset($image['path'])) $params[":path"] = $image['path'];
    if (isset($image['weight'])) $params[":weight"] = $image['weight'];
    if (isset($image['extention'])) $params[":extention"] = $image['extention'];
    if (isset($image['is_deleted'])) $params[":is_deleted"] = $image['is_deleted'];

    $result = Database::queryUpdate($sql, $params);

    if ($result['success']) {
        log_txt("Image updated in back office: id " . $image['slug']);
        return true;
    } else {
        return false;
    }
}

function putToTrashImage($slug)
{

    $sql = "UPDATE image SET is_deleted = 1 WHERE slug = :slug";

    $params = array(":slug" => $slug);

    $result = Database::queryUpdate($sql, $params);

    if ($result['success']) {
        log_txt("Image deleted in back office: id " . $slug);
        return true;
    } else {
        return false;
    }
}
