<?php

include_once APP_PATH . 'helpers/slugify.php';

function getMaterial($slug)
{
    $sql = "SELECT * FROM material WHERE slug = :slug;";

    $result = Database::queryOne($sql, array(":slug" => $slug));

    return $result['data'];
}

function getMaterials($search = null, $sort =  array(array('order' => 'ASC', 'order_by' => 'libelle')), $offset = null, $per_page = 10)
{

    // Select all materials
    $sql = "SELECT * FROM material";

    // Use WHERE 1 = 1 to be able to add conditions with AND
    $sql .= " WHERE 1 = 1";

    $sql .= " AND is_deleted = 0";

    // Filter by search
    if ($search) {
        $sql .= " AND (
        libelle LIKE :like_search OR
        slug LIKE :like_search OR
        SOUNDEX(libelle) = SOUNDEX(:soundex_search) OR
        SOUNDEX(slug) = SOUNDEX(:soundex_search)
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

function getMaterialsCount($search = null)
{

    // Select all materials
    $sql = "SELECT COUNT(DISTINCT material.slug) as count FROM material";

    // Use WHERE 1 = 1 to be able to add conditions with AND
    $sql .= " WHERE 1 = 1";

    $sql .= " AND is_deleted = 0";

    // Filter by search
    if ($search) {
        $sql .= " AND (
        libelle LIKE :like_search OR
        slug LIKE :like_search OR
        SOUNDEX(libelle) = SOUNDEX(:soundex_search) OR
        SOUNDEX(slug) = SOUNDEX(:soundex_search)
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

function getMaterialsFromProduct($product_slug)
{
    $sql = "SELECT material.* FROM product, product_material, material 
    WHERE product.slug = :product_slug AND material.is_deleted = 0
    AND product_material.material_slug = material.slug AND product_material.product_slug = product.slug;";

    $result = Database::queryAll($sql, array(":product_slug" => $product_slug));

    return $result['data'];
}

function insertMaterial($material)
{

    $sql = "INSERT INTO material (libelle, slug, color) VALUES (:libelle, :slug, :color)";

    if (!$material['slug']) $material['slug'] = slugify($material['libelle']);

    $params = array(":libelle" => $material['libelle'], ":slug" => $material['slug'], ":color" => $material['color']);

    $result = Database::queryInsert($sql, $params);

    if ($result['success']) {
        log_txt("Address inserted in back office: address_id " . $result["lastInsertId"]);
        return true;
    } else {
        return false;
    }
}

function updateMaterial($material)
{
    $sql = "UPDATE material SET";

    if (isset($material['libelle'])) $sql .= " libelle = :libelle,";
    if (isset($material['color'])) $sql .= " color = :color,";
    if (isset($material['is_deleted'])) $sql .= " is_deleted = :is_deleted,";

    $sql = rtrim($sql, ",");

    $sql .= " WHERE slug = :slug";

    $params = array();

    // Bind values
    if (isset($material['libelle'])) $params[":libelle"] = $material['libelle'];
    if (isset($material['color'])) $params[":color"] = $material['color'];
    if (isset($material['is_deleted'])) $params[":is_deleted"] = $material['is_deleted'];
    $params[":slug"] = $material['slug'];

    $result = Database::queryUpdate($sql, $params);

    if ($result['success']) {
        log_txt("Material updated in back office: slug " . $material['slug']);
        return true;
    } else {
        return false;
    }
}

function putToTrashMaterial($slug)
{

    $sql = "UPDATE material SET is_deleted = 1 WHERE slug = :slug";

    $params = array(":slug" => $slug);

    $result = Database::queryUpdate($sql, $params);

    if ($result['success']) {
        log_txt("Material deleted in back office: slug " . $slug);
        return true;
    } else {
        return false;
    }
}
