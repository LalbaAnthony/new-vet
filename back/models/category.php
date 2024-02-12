<?php

include_once APP_PATH . '/helpers/slugify.php';

function getCategory($slug)
{
    $dbh = db_connect();
    $sql = "SELECT * FROM category WHERE slug = :slug;";
    try {
        $sth = $dbh->prepare($sql);
        $sth->execute(array(":slug" => $slug));
        $category = $sth->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Erreur lors de la requête SQL : " . $e->getMessage());
    }

    return $category;
}

function getCategories($search = null, $sort =  array(array('order' => 'ASC', 'order_by' => 'sort_order')), $offset = null, $per_page = 10, $is_highlander = false, $exclude = array(), $include = array())
{
    $dbh = db_connect();

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
        
        // Bind values for exclude
        if (count($exclude) > 0 && count($include) == 0) {
            foreach ($exclude as $key => $value) {
                $sth->bindValue(":exclude_$key", $value);
            }
        }
        
        // Bind values for include
        if (count($include) > 0 && count($exclude) == 0) {
            foreach ($include as $key => $value) {
                $sth->bindValue(":include_$key", $value);
            }
        }
        
        // Bind values
        if ($search) $sth->bindValue(":search", "%$search%");
        if ($per_page) $sth->bindValue(":per_page", $per_page, PDO::PARAM_INT);
        if ($offset) $sth->bindValue(":offset", $offset, PDO::PARAM_INT);

        $sth->execute();

        $categories = $sth->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Erreur lors de la requête SQL : " . $e->getMessage());
    }

    return $categories;
}

function getCategoriesCount() {
    $dbh = db_connect();
    $sql = "SELECT COUNT(*) FROM category WHERE is_deleted = 0";
    try {
        $sth = $dbh->prepare($sql);
        $sth->execute();
        $count = $sth->fetchColumn();
    } catch (PDOException $e) {
        die("Erreur lors de la requête SQL : " . $e->getMessage());
    }

    return $count;
}

function getCategoriesFromProduct($product_slug)
{
    $dbh = db_connect();
    $sql = "SELECT category.* FROM product, product_category, category 
    WHERE product.slug = :product_slug AND category.is_deleted = 0
    AND product_category.category_slug = category.slug AND product_category.product_slug = product.slug
    ORDER BY category.sort_order ASC;";
    try {
        $sth = $dbh->prepare($sql);
        $sth->execute(array(":product_slug" => $product_slug));
        $categories = $sth->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Erreur lors de la requête SQL : " . $e->getMessage());
    }

    return $categories;
}

function getCategoriesQuickAccess()
{
    $dbh = db_connect();
    $sql = "SELECT * FROM category WHERE is_quick_access = 1 AND is_deleted = 0 ORDER BY category.sort_order ASC;";
    try {
        $sth = $dbh->prepare($sql);
        $sth->execute();
        $categories = $sth->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Erreur lors de la requête SQL : " . $e->getMessage());
    }

    return $categories;
}

function insertCategory($category)
{
    $dbh = db_connect();

    $sql = "INSERT INTO category (slug, libelle, image_path, sort_order, is_quick_access, is_highlander, color) VALUES (:slug, :libelle, :image_path, :sort_order, :is_quick_access, :is_highlander, :color)";

    if (!$category['slug']) $category['slug'] = slugify($category['libelle']);
    if (!$category['image_path']) $category['image_path'] = "/assets/others/default-img.webp";

    try {
        $sth = $dbh->prepare($sql);
        $sth->execute(array(":slug" => $category['slug'], ":libelle" => $category['libelle'], ":image_path" => $category['image_path'], ":sort_order" => $category['sort_order'], ":is_quick_access" => $category['is_quick_access'], ":is_highlander" => $category['is_highlander'], ":color" => $category['color']));
        if ($sth->rowCount() > 0) {
            log_txt("Category registered in back office: slug " . $category['slug']);
            return true;
        } else {
            return false;
        }
    } catch (PDOException $e) {
        die("Erreur lors de la requête SQL : " . $e->getMessage());
    }
}

function updateCategory($category)
{
    $dbh = db_connect();

    $sql = "UPDATE category SET libelle = :libelle, image_path = :image_path, sort_order = :sort_order, is_quick_access = :is_quick_access, is_highlander = :is_highlander, color = :color WHERE slug = :slug";

    try {
        $sth = $dbh->prepare($sql);
        $sth->execute(array(":slug" => $category['slug'], ":libelle" => $category['libelle'], ":image_path" => $category['image_path'], ":sort_order" => $category['sort_order'], ":is_quick_access" => $category['is_quick_access'], ":is_highlander" => $category['is_highlander'], ":color" => $category['color']));
        if ($sth->rowCount() > 0) {
            log_txt("Category updated in back office: slug " . $category['slug']);
            return true;
        } else {
            return false;
        }
    } catch (PDOException $e) {
        die("Erreur lors de la requête SQL : " . $e->getMessage());
    }
}

function deleteCategory($slug)
{
    $dbh = db_connect();

    $sql = "UPDATE category SET is_deleted = 1 WHERE slug = :slug";

    try {
        $sth = $dbh->prepare($sql);
        $sth->execute(array(":slug" => $slug));
        if ($sth->rowCount() > 0) {
            log_txt("Category deleted: slug $slug");
            return true;
        } else {
            return false;
        }
    } catch (PDOException $e) {
        die("Erreur lors de la requête SQL : " . $e->getMessage());
    }
}
