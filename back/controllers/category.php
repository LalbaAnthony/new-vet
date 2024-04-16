<?php

include_once APP_PATH . 'helpers/slugify.php';

function getCategory($slug)
{
    $sql = "SELECT * FROM category WHERE slug = :slug;";

    $params = array(":slug" => $slug);

    $result = Database::queryOne($sql, $params);

    return $result['data'];
}

function getCategories($search = null, $is_highlander = false, $is_quick_access = false, $exclude = array(), $include = array(), $sort =  array(array('order' => 'ASC', 'order_by' => 'sort_order')), $offset = null, $per_page = 10)
{

    // Select all categories
    $sql = "SELECT * FROM category";

    // Use WHERE 1 = 1 to be able to add conditions with AND
    $sql .= " WHERE 1 = 1";

    $sql .= " AND is_deleted = 0";

    // Exclude categories
    if ($exclude) {
        $sql .= " AND (";
        foreach ($exclude as $key => $value) {
            $sql .= "slug != :exclude_$key";
            if ($key < count($exclude) - 1) $sql .= " AND ";
        }
        $sql .= ")";
    }

    // Include categories
    if ($include) {
        $sql .= " AND (";
        foreach ($include as $key => $value) {
            $sql .= "slug = :include_$key";
            if ($key < count($include) - 1) $sql .= " AND ";
        }
        $sql .= ")";
    }

    // Filter by search
    if ($search) {
        $sql .= " AND (
        libelle LIKE :search OR
        slug LIKE :search OR
        SOUNDEX(libelle) = SOUNDEX(:search) OR
        SOUNDEX(slug) = SOUNDEX(:search)
        )";
    }

    // Filter by is_highlander
    if ($is_highlander) $sql .= " AND is_highlander = 1";

    // Filter by is_quick_access
    if ($is_quick_access) $sql .= " AND is_quick_access = 1";

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

    // Bind values for exclude
    if ($exclude && count($exclude) > 0 && count($include) == 0) {
        foreach ($exclude as $key => $value) {
            $params[":exclude_$key"] = $value;
        }
    }

    // Bind values for include
    if ($include && count($include) > 0 && count($exclude) == 0) {
        foreach ($include as $key => $value) {
            $params[":include_$key"] = $value;
        }
    }

    // Bind values
    if ($search) $params[":search"] = "%$search%";
    if ($per_page) $params[":per_page"] = $per_page;
    if ($offset) $params[":offset"] = $offset;

    $result = Database::queryAll($sql, $params);

    return $result['data'];
}

function getCategoriesCount($search = null, $is_highlander = false, $is_quick_access = false, $exclude = array(), $include = array())
{

    // Select all categories
    $sql = "SELECT COUNT(*) as count FROM category";

    // Use WHERE 1 = 1 to be able to add conditions with AND
    $sql .= " WHERE 1 = 1";

    $sql .= " AND is_deleted = 0";

    // Exclude categories
    if ($exclude) {
        $sql .= " AND (";
        foreach ($exclude as $key => $value) {
            $sql .= "slug != :exclude_$key";
            if ($key < count($exclude) - 1) $sql .= " AND ";
        }
        $sql .= ")";
    }

    // Include categories
    if ($include) {
        $sql .= " AND (";
        foreach ($include as $key => $value) {
            $sql .= "slug = :include_$key";
            if ($key < count($include) - 1) $sql .= " AND ";
        }
        $sql .= ")";
    }

    // Filter by search
    if ($search) {
        $sql .= " AND (
        libelle LIKE :search OR
        slug LIKE :search OR
        SOUNDEX(libelle) = SOUNDEX(:search) OR
        SOUNDEX(slug) = SOUNDEX(:search)
        )";
    }

    // Filter by is_highlander
    if ($is_highlander) $sql .= " AND is_highlander = 1";

    // Filter by is_quick_access
    if ($is_quick_access) $sql .= " AND is_quick_access = 1";

    $params = array();

    // Bind values for exclude
    if ($exclude && count($exclude) > 0 && count($include) == 0) {
        foreach ($exclude as $key => $value) {
            $params[":exclude_$key"] = $value;
        }
    }

    // Bind values for include
    if ($include && count($include) > 0 && count($exclude) == 0) {
        foreach ($include as $key => $value) {
            $params[":include_$key"] = $value;
        }
    }

    // Bind values
    if ($search) $params[":search"] = "%$search%";

    $result = Database::queryOne($sql, $params);

    return $result['data']['count'];
}

function getCategoriesFromProduct($product_slug)
{
    $sql = "SELECT category.* FROM product, product_category, category 
    WHERE product.slug = :product_slug AND category.is_deleted = 0
    AND product_category.category_slug = category.slug AND product_category.product_slug = product.slug
    ORDER BY category.sort_order ASC;";

    $params = array(":product_slug" => $product_slug);

    $result = Database::queryAll($sql, $params);

    return $result['data'];
}

function insertCategory($category)
{

    $sql = "INSERT INTO category (slug, libelle, path, sort_order, is_quick_access, is_highlander, color) VALUES (:slug, :libelle, :path, :sort_order, :is_quick_access, :is_highlander, :color)";

    if (!$category['slug']) $category['slug'] = slugify($category['libelle']);
    if (!$category['path']) $category['path'] = "/assets/others/default-img.webp";


    $params = array(":slug" => $category['slug'], ":libelle" => $category['libelle'], ":path" => $category['path'], ":sort_order" => $category['sort_order'], ":is_quick_access" => $category['is_quick_access'], ":is_highlander" => $category['is_highlander'], ":color" => $category['color']);

    $reslut = Database::queryInsert($sql, $params);

    if ($reslut['lastInsertId']) {
        log_txt("Category inserted in back office: slug " . $category['slug']);
        return true;
    } else {
        return false;
    }
}

function updateCategory($category)
{

    // $sql = "UPDATE category SET libelle = :libelle, path = :path, sort_order = :sort_order, is_quick_access = :is_quick_access, is_highlander = :is_highlander, color = :color WHERE slug = :slug";

    $sql = "UPDATE category SET";

    if (isset($category['slug'])) $sql .= " slug = :slug,";
    if (isset($category['libelle'])) $sql .= " libelle = :libelle,";
    if (isset($category['path'])) $sql .= " path = :path,";
    if (isset($category['sort_order'])) $sql .= " sort_order = :sort_order,";
    if (isset($category['is_quick_access'])) $sql .= " is_quick_access = :is_quick_access,";
    if (isset($category['is_highlander'])) $sql .= " is_highlander = :is_highlander,";
    if (isset($category['color'])) $sql .= " color = :color,";
    if (isset($category['is_deleted'])) $sql .= " is_deleted = :is_deleted,";
    
    $sql = rtrim($sql, ","); // cut off the last comma
    
    $sql .= " WHERE slug = :slug";
    
    $params = array();
    if (isset($category['slug'])) $params[":slug"] = $category['slug'];
    if (isset($category['libelle'])) $params[":libelle"] = $category['libelle'];
    if (isset($category['path'])) $params[":path"] = $category['path'];
    if (isset($category['sort_order'])) $params[":sort_order"] = $category['sort_order'];
    if (isset($category['is_quick_access'])) $params[":is_quick_access"] = $category['is_quick_access'];
    if (isset($category['is_highlander'])) $params[":is_highlander"] = $category['is_highlander'];
    if (isset($category['color'])) $params[":color"] = $category['color'];
    if (isset($category['is_deleted'])) $params[":is_deleted"] = $category['is_deleted'];

    $reslut = Database::queryUpdate($sql, $params);

    if ($reslut['success']) {
        log_txt("Category updated in back office: slug " . $category['slug']);
        return true;
    } else {
        return false;
    }
}

function putToTrashCategory($slug)
{

    $sql = "UPDATE category SET is_deleted = 1 WHERE slug = :slug";

    $params = array(":slug" => $slug);

    $reslut = Database::queryUpdate($sql, $params);

    if ($reslut['success']) {
        log_txt("Category deleted in back office: slug " . $slug);
        return true;
    } else {
        return false;
    }
}
