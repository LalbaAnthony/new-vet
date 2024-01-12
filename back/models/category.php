<?php

include_once '../helpers/slugify.php';

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

function getCategories($search = null, $order_by = 'sort_order', $order = 'ASC', $offset = null, $per_page = 10)
{
    $dbh = db_connect();

    // Select all categories
    $sql = "SELECT * FROM category";

    // Use WHERE 1 = 1 to be able to add conditions with AND
    $sql .= " WHERE 1 = 1";

    // Filter by search
    if ($search) $sql .= " AND libelle LIKE :search";

    $sql .= " ORDER BY :order_by :order";
    if ($per_page) $sql .= " LIMIT :per_page";
    if ($offset) $sql .= " OFFSET :offset";

    try {
        $sth = $dbh->prepare($sql);

        // Bind values
        if ($search) $sth->bindValue(":search", "%$search%");
        $sth->bindValue(":order_by", $order_by);
        $sth->bindValue(":order", $order);
        if ($per_page) $sth->bindValue(":per_page", $per_page, PDO::PARAM_INT);
        if ($offset) $sth->bindValue(":offset", $offset, PDO::PARAM_INT);

        $sth->execute();

        $categories = $sth->fetchAll(PDO::FETCH_ASSOC);
        log_txt("Read categories");
    } catch (PDOException $e) {
        die("Erreur lors de la requête SQL : " . $e->getMessage());
    }

    return $categories;
}

function getCategoriesFromProduct($product_slug)
{
    $dbh = db_connect();
    $sql = "SELECT category.* FROM product, product_category, category 
    WHERE product.slug = :product_slug
    AND product_category.category_slug = category.slug AND product_category.product_slug = product.slug
    ORDER BY category.sort_order ASC;";
    try {
        $sth = $dbh->prepare($sql);
        $sth->execute(array(":product_slug" => $product_slug));
        $categories = $sth->fetchAll(PDO::FETCH_ASSOC);
        log_txt("Read categories from product $product_slug");
    } catch (PDOException $e) {
        die("Erreur lors de la requête SQL : " . $e->getMessage());
    }

    return $categories;
}

function getCategoriesQuickAcces()
{
    $dbh = db_connect();
    $sql = "SELECT * FROM category WHERE quick_access = 1 ORDER BY category.sort_order ASC;";
    try {
        $sth = $dbh->prepare($sql);
        $sth->execute();
        $categories = $sth->fetchAll(PDO::FETCH_ASSOC);
        log_txt("Read categories quick access");
    } catch (PDOException $e) {
        die("Erreur lors de la requête SQL : " . $e->getMessage());
    }

    return $categories;
}

function insertCategory($category)
{
    $dbh = db_connect();

    $sql = "INSERT INTO category (slug, libelle, image_path, sort_order, quick_access) VALUES (:slug, :libelle, :image_path, :sort_order, :quick_access)";

    if (!$category['slug']) $category['slug'] = slugify($category['libelle']);
    if (!$category['image_path']) $category['image_path'] = "/assets/others/no-img-available.webp";
    if (!$category['sort_order']) {
        $allCategories = getCategories(null, 'sort_order', 'ASC', null, 999);
        $material['sort_order'] = $allCategories[0]['sort_order'] + 1;
    }

    try {
        $sth = $dbh->prepare($sql);
        $sth->execute(array(":slug" => $category['slug'], ":libelle" => $category['libelle'], ":image_path" => $category['image_path'], ":sort_order" => $category['sort_order'], ":quick_access" => $category['quick_access']));
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

    $sql = "UPDATE category SET libelle = :libelle, image_path = :image_path, sort_order = :sort_order, quick_access = :quick_access WHERE slug = :slug";

    try {
        $sth = $dbh->prepare($sql);
        $sth->execute(array(":slug" => $category['slug'], ":libelle" => $category['libelle'], ":image_path" => $category['image_path'], ":sort_order" => $category['sort_order'], ":quick_access" => $category['quick_access']));
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

    $sql = "DELETE FROM category WHERE slug = :slug";

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
