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

function getProducts($categories_slugs = array(), $materials_slugs = array(), $search = null, $order_by = 'sort_order', $order = 'ASC', $offset = null, $per_page = 10, $is_highlander = false, $exclude = array())
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

    // Exclude products
    if ($exclude) {
        $sql .= " AND (";
        foreach ($exclude as $key => $value) {
            $sql .= "product.slug != :exclude_$key";
            if ($key < count($exclude) - 1) $sql .= " AND ";
        }
        $sql .= ")";
    }

    // Filter by category slug (loop through the array of category slugs)
    if ($categories_slugs) {
        $sql .= " AND (";
        foreach ($categories_slugs as $key => $value) {
            $sql .= "category.slug = :category_slug_$key";
            if ($key < count($categories_slugs) - 1) $sql .= " OR ";
        }
        $sql .= ")";
    }

    // Filter by material slug (loop through the array of material slugs)
    if ($materials_slugs) {
        $sql .= " AND (";
        foreach ($materials_slugs as $key => $value) {
            $sql .= "material.slug = :material_slug_$key";
            if ($key < count($materials_slugs) - 1) $sql .= " OR ";
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

        // Bind values for exclude (loop through the array of slugs to exclude)
        if ($exclude) {
            foreach ($exclude as $key => $value) {
                $sth->bindValue(":exclude_$key", $value);
            }
        }

        // Bind values for category slug (loop through the array of category slugs)
        if ($categories_slugs) {
            foreach ($categories_slugs as $key => $value) {
                $sth->bindValue(":category_slug_$key", $value);
            }
        }

        // Bind values for material slug (loop through the array of material slugs)
        if ($materials_slugs) {
            foreach ($materials_slugs as $key => $value) {
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

    $sql = "INSERT INTO product (name, slug, description, price, is_highlander, stock_quantity, sort_order) VALUES (:name, :slug, :description, :price, :is_highlander, :stock_quantity, :sort_order)";

    if (!$product['slug']) $product['slug'] = slugify($product['name']);

    try {
        $sth = $dbh->prepare($sql);
        $sth->execute(array(":name" => $product['name'], ":slug" => $product['slug'], ":description" => $product['description'], ":price" => $product['price'], ":is_highlander" => $product['is_highlander'], ":stock_quantity" => $product['stock_quantity'], ":sort_order" => $product['sort_order']));
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

    $sql = "UPDATE product SET name = :name, description = :description, price = :price, is_highlander = :is_highlander, stock_quantity = :stock_quantity, sort_order = :sort_order WHERE slug = :slug";

    try {
        $sth = $dbh->prepare($sql);
        $sth->execute(array(":name" => $product['name'], ":slug" => $product['slug'], ":description" => $product['description'], ":price" => $product['price'], ":is_highlander" => $product['is_highlander'], ":stock_quantity" => $product['stock_quantity'], ":sort_order" => $product['sort_order']));
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

function updateProductCategories($product_slug, $categories_slugs)
{
    $dbh = db_connect();

    // Delete all categories for this product
    $sql = "DELETE FROM product_category WHERE product_slug = :product_slug";
    try {
        $sth = $dbh->prepare($sql);
        $sth->execute(array(":product_slug" => $product_slug));
        log_txt("Product categories deleted in back office: slug " . $product_slug);
    } catch (PDOException $e) {
        die("Erreur lors de la requête SQL : " . $e->getMessage());
    }

    // Insert all categories for this product
    $sql = "INSERT INTO product_category (product_slug, category_slug) VALUES (:product_slug, :category_slug)";
    try {
        $sth = $dbh->prepare($sql);
        foreach ($categories_slugs as $key => $value) {
            $sth->execute(array(":product_slug" => $product_slug, ":category_slug" => $value));
        }
        log_txt("Product categories inserted in back office: slug " . $product_slug);
        return true;
    } catch (PDOException $e) {
        die("Erreur lors de la requête SQL : " . $e->getMessage());
    }
}

function updateProductMaterials($product_slug, $materials_slugs)
{
    $dbh = db_connect();

    // Delete all materials for this product
    $sql = "DELETE FROM product_material WHERE product_slug = :product_slug";
    try {
        $sth = $dbh->prepare($sql);
        $sth->execute(array(":product_slug" => $product_slug));
        log_txt("Product materials deleted in back office: slug " . $product_slug);
    } catch (PDOException $e) {
        die("Erreur lors de la requête SQL : " . $e->getMessage());
    }

    // Insert all materials for this product
    $sql = "INSERT INTO product_material (product_slug, material_slug) VALUES (:product_slug, :material_slug)";
    try {
        $sth = $dbh->prepare($sql);
        foreach ($materials_slugs as $key => $value) {
            $sth->execute(array(":product_slug" => $product_slug, ":material_slug" => $value));
        }
        log_txt("Product materials inserted in back office: slug " . $product_slug);
        return true;
    } catch (PDOException $e) {
        die("Erreur lors de la requête SQL : " . $e->getMessage());
    }
}

function deleteProduct($slug)
{
    $dbh = db_connect();
    $sql = "UPDATE product SET is_deleted = 1 WHERE slug = :slug";
    echo $sql;
    try {
        $sth = $dbh->prepare($sql);
        $sth->execute(array(":slug" => $slug));
        if ($sth->rowCount() > 0) {
            log_txt("Product deleted in back office: slug " . $slug);
            return true;
        } else {
            return false;
        }
    } catch (PDOException $e) {
        die("Erreur lors de la requête SQL : " . $e->getMessage());
    }
}
