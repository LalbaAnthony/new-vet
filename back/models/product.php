<?php

include_once APP_PATH . '/helpers/slugify.php';

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

function getProducts($category_slug = array(), $material_slug = array(), $search = null, $order_by = 'created_at', $order = 'DESC', $offset = null, $per_page = 10, $is_highlander = false)
{

    $dbh = db_connect();

    // Select all products, with their categories and materials (we use LEFT JOIN to get products without categories or materials)
    $sql = "SELECT product.* FROM product
    LEFT JOIN product_category ON product_category.product_slug = product.slug
    LEFT JOIN category ON product_category.category_slug = category.slug
    LEFT JOIN product_material ON product_material.product_slug = product.slug
    LEFT JOIN material ON product_material.material_slug = material.slug";

    // Use WHERE 1 = 1 to be able to add conditions with AND
    $sql .= " WHERE 1 = 1";

    $sql .= " AND product.is_deleted = 0";

    // Filter by category slug (loop through the array of category slugs)
    if ($category_slug) {
        $sql .= " AND (";
        foreach ($category_slug as $key => $value) {
            $sql .= "category.slug = :category_slug_$key";
            if ($key < count($category_slug) - 1) $sql .= " OR ";
        }
        $sql .= ")";
    }

    // Filter by material slug (loop through the array of material slugs)
    if ($material_slug) {
        $sql .= " AND (";
        foreach ($material_slug as $key => $value) {
            $sql .= "material.slug = :material_slug_$key";
            if ($key < count($material_slug) - 1) $sql .= " OR ";
        }
        $sql .= ")";
    }

    // Filter by search (search in name, description, price, category libelle and material libelle)
    if ($search) $sql .= " AND (name LIKE :search OR description LIKE :search OR price LIKE :search OR category.libelle LIKE :search OR material.libelle LIKE :search)";

    if ($is_highlander) $sql .= " AND is_highlander = 1";

    $sql .= " ORDER BY $order_by $order";
    if ($per_page) $sql .= " LIMIT :per_page";
    if ($offset) $sql .= " OFFSET :offset";

    try {
        $sth = $dbh->prepare($sql);

        // Bind values for category slug (loop through the array of category slugs)
        if ($category_slug) {
            foreach ($category_slug as $key => $value) {
                $sth->bindValue(":category_slug_$key", $value);
            }
        }

        // Bind values for material slug (loop through the array of material slugs)
        if ($material_slug) {
            foreach ($material_slug as $key => $value) {
                $sth->bindValue(":material_slug_$key", $value);
            }
        }

        // Bind others values
        if ($search) $sth->bindValue(":search", "%$search%");
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

function insertProduct($product)
{
    $dbh = db_connect();

    $sql = "INSERT INTO product (name, slug, description, price, is_highlander, stock_quantity) VALUES (:name, :slug, :description, :price, :is_highlander, :stock_quantity)";

    if (!$product['slug']) $product['slug'] = slugify($product['name']);

    try {
        $sth = $dbh->prepare($sql);
        $sth->execute(array(":name" => $product['name'], ":slug" => $product['slug'], ":description" => $product['description'], ":price" => $product['price'], ":is_highlander" => $product['is_highlander'], ":stock_quantity" => $product['stock_quantity']));
        if ($sth->rowCount() > 0) {
            log_txt("Product registered in back office: name " . $product['name']);
            return true;
        } else {
            return false;
        }
    } catch (PDOException $e) {
        die("Erreur lors de la requête SQL : " . $e->getMessage());
    }
}

function updateProduct($product)
{
    $dbh = db_connect();

    $sql = "UPDATE product SET name = :name, description = :description, price = :price, is_highlander = :is_highlander, stock_quantity = :stock_quantity WHERE slug = :slug";

    try {
        $sth = $dbh->prepare($sql);
        $sth->execute(array(":name" => $product['name'], ":slug" => $product['slug'], ":description" => $product['description'], ":price" => $product['price'], ":is_highlander" => $product['is_highlander'], ":stock_quantity" => $product['stock_quantity']));
        if ($sth->rowCount() > 0) {
            log_txt("Product updated in back office: slug " . $product['slug']);
            return true;
        } else {
            return false;
        }
    } catch (PDOException $e) {
        die("Erreur lors de la requête SQL : " . $e->getMessage());
    }
}

function deleteProduct($slug)
{
    $dbh = db_connect();
    $sql = "UPDATE product SET is_deleted = 1 WHERE slug = :slug";
    try {
        $sth = $dbh->prepare($sql);
        $sth->execute(array(":slug" => $slug));
        log_txt("Product deleted: slug $slug");
    } catch (PDOException $e) {
        die("Erreur lors de la requête SQL : " . $e->getMessage());
    }
}
