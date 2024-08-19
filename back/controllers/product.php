<?php

include_once APP_PATH . 'helpers/slugify.php';

function getProduct($slug)
{
    $sql = "SELECT * FROM product WHERE slug = :slug;";

    $params = array(":slug" => $slug);

    $result = Database::queryOne($sql, $params);

    return $result['data'];
}

function getProducts($categories = array(), $materials = array(), $search = null, $is_highlander = false, $exclude = array(), $include = array(), $sort =  array(array('order' => 'ASC', 'order_by' => 'sort_order'), array('order' => 'DESC', 'order_by' => 'stock_quantity')), $offset = null, $per_page = 10)
{
    // Select all products, with their categories and materials (we use LEFT JOIN to get products without categories or materials)
    $sql = "SELECT DISTINCT product.* FROM product
    LEFT JOIN product_category ON product_category.product_slug = product.slug
    LEFT JOIN category ON product_category.category_slug = category.slug
    LEFT JOIN product_material ON product_material.product_slug = product.slug
    LEFT JOIN material ON product_material.material_slug = material.slug";

    // Use WHERE 1 = 1 to be able to add conditions with AND
    $sql .= " WHERE 1 = 1";

    $sql .= " AND product.is_deleted = 0";

    // Exclude products
    if ($exclude && !$include) {
        $sql .= " AND (";
        foreach ($exclude as $key => $value) {
            $sql .= "product.slug != :exclude_$key";
            if ($key < count($exclude) - 1) $sql .= " AND ";
        }
        $sql .= ")";
    }

    // Include products
    if ($include && !$exclude) {
        $sql .= " AND (";
        foreach ($include as $key => $value) {
            $sql .= "product.slug = :include_$key";
            if ($key < count($include) - 1) $sql .= " OR ";
        }
        $sql .= ")";
    }

    // Filter by category slug (loop through the array of category slugs)
    if ($categories) {
        $sql .= " AND (";
        foreach ($categories as $key => $value) {
            $sql .= "category.slug = :category_slug_$key";
            if ($key < count($categories) - 1) $sql .= " OR ";
        }
        $sql .= ")";
    }

    // Filter by material slug (loop through the array of material slugs)
    if ($materials) {
        $sql .= " AND (";
        foreach ($materials as $key => $value) {
            $sql .= "material.slug = :material_slug_$key";
            if ($key < count($materials) - 1) $sql .= " OR ";
        }
        $sql .= ")";
    }

    // Filter by search
    if ($search) {
        $sql .= " AND (
        product.slug LIKE :like_search OR 
        product.name LIKE :like_search OR
        product.description LIKE :like_search OR
        product.price LIKE :like_search OR
        category.slug LIKE :like_search OR
        material.slug LIKE :like_search OR
        category.libelle LIKE :like_search OR
        material.libelle LIKE :like_search OR
        SOUNDEX(product.name) = SOUNDEX(:soundex_search) OR
        SOUNDEX(product.description) = SOUNDEX(:soundex_search) OR
        SOUNDEX(product.price) = SOUNDEX(:soundex_search) OR
        SOUNDEX(category.libelle) = SOUNDEX(:soundex_search) OR
        SOUNDEX(material.libelle) = SOUNDEX(:soundex_search)
    )";
    }

    if ($is_highlander) $sql .= " AND product.is_highlander = 1";

    // Sort
    if ($sort) {
        $sql .= " ORDER BY ";
        foreach ($sort as $key => $value) {
            $sql .= "COALESCE(product." . $value['order_by'] . ", 9999999) " . strtoupper($value['order']); // COALESCE to avoid NULL values
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

    // Bind values for category slug
    if ($categories) {
        foreach ($categories as $key => $value) {
            $params[":category_slug_$key"] = $value;
        }
    }

    // Bind values for material slug
    if ($materials) {
        foreach ($materials as $key => $value) {
            $params[":material_slug_$key"] = $value;
        }
    }

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

function getProductsCount($categories = array(), $materials = array(), $search = null, $is_highlander = false, $exclude = array(), $include = array())
{

    // Select all products, with their categories and materials (we use LEFT JOIN to get products without categories or materials)
    $sql = "SELECT COUNT(DISTINCT product.slug) as count FROM product
    LEFT JOIN product_category ON product_category.product_slug = product.slug
    LEFT JOIN category ON product_category.category_slug = category.slug
    LEFT JOIN product_material ON product_material.product_slug = product.slug
    LEFT JOIN material ON product_material.material_slug = material.slug";

    // Use WHERE 1 = 1 to be able to add conditions with AND
    $sql .= " WHERE 1 = 1";

    $sql .= " AND product.is_deleted = 0";

    // Exclude products
    if ($exclude && !$include) {
        $sql .= " AND (";
        foreach ($exclude as $key => $value) {
            $sql .= "product.slug != :exclude_$key";
            if ($key < count($exclude) - 1) $sql .= " AND ";
        }
        $sql .= ")";
    }

    // Include products
    if ($include && !$exclude) {
        $sql .= " AND (";
        foreach ($include as $key => $value) {
            $sql .= "product.slug = :include_$key";
            if ($key < count($include) - 1) $sql .= " OR ";
        }
        $sql .= ")";
    }

    // Filter by category slug (loop through the array of category slugs)
    if ($categories) {
        $sql .= " AND (";
        foreach ($categories as $key => $value) {
            $sql .= "category.slug = :category_slug_$key";
            if ($key < count($categories) - 1) $sql .= " OR ";
        }
        $sql .= ")";
    }

    // Filter by material slug (loop through the array of material slugs)
    if ($materials) {
        $sql .= " AND (";
        foreach ($materials as $key => $value) {
            $sql .= "material.slug = :material_slug_$key";
            if ($key < count($materials) - 1) $sql .= " OR ";
        }
        $sql .= ")";
    }

    // Filter by search
    if ($search) {
        $sql .= " AND (
            product.slug LIKE :like_search OR 
            product.name LIKE :like_search OR
            product.description LIKE :like_search OR
            product.price LIKE :like_search OR
            category.slug LIKE :like_search OR
            material.slug LIKE :like_search OR
            category.libelle LIKE :like_search OR
            material.libelle LIKE :like_search OR
            SOUNDEX(product.name) = SOUNDEX(:soundex_search) OR
            SOUNDEX(product.description) = SOUNDEX(:soundex_search) OR
            SOUNDEX(product.price) = SOUNDEX(:soundex_search) OR
            SOUNDEX(category.libelle) = SOUNDEX(:soundex_search) OR
            SOUNDEX(material.libelle) = SOUNDEX(:soundex_search)
        )";
    }

    if ($is_highlander) $sql .= " AND product.is_highlander = 1";

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

    // Bind values for category slug
    if ($categories) {
        foreach ($categories as $key => $value) {
            $params[":category_slug_$key"] = $value;
        }
    }

    // Bind values for material slug
    if ($materials) {
        foreach ($materials as $key => $value) {
            $params[":material_slug_$key"] = $value;
        }
    }

    // Bind values
    if ($search) {
        $params[":like_search"] = "'%$search%'";
        $params[":soundex_search"] = "'$search'";
    }

    $result = Database::queryOne($sql, $params);

    return $result['data']['count'];
}

function insertProduct($product)
{

    $sql = "INSERT INTO product (name, slug, description, price, is_highlander, stock_quantity, sort_order) VALUES (:name, :slug, :description, :price, :is_highlander, :stock_quantity, :sort_order)";

    if (!$product['slug']) $product['slug'] = slugify($product['name']);

    $result = Database::queryInsert($sql, array(":name" => $product['name'], ":slug" => $product['slug'], ":description" => $product['description'], ":price" => $product['price'], ":is_highlander" => $product['is_highlander'], ":stock_quantity" => $product['stock_quantity'], ":sort_order" => $product['sort_order']));

    if ($result['success']) {
        log_txt("Address inserted in back office: address_id " . $result["lastInsertId"]);
        return true;
    } else {
        return false;
    }
}

function updateProduct($product)
{

    // $sql = "UPDATE product SET name = :name, description = :description, price = :price, is_highlander = :is_highlander, stock_quantity = :stock_quantity, sort_order = :sort_order WHERE slug = :slug";

    $sql = "UPDATE product SET";

    if (isset($product['slug'])) $sql .= " slug = :slug,";
    if (isset($product['name'])) $sql .= " name = :name,";
    if (isset($product['description'])) $sql .= " description = :description,";
    if (isset($product['price'])) $sql .= " price = :price,";
    if (isset($product['is_highlander'])) $sql .= " is_highlander = :is_highlander,";
    if (isset($product['stock_quantity'])) $sql .= " stock_quantity = :stock_quantity,";
    if (isset($product['sort_order'])) $sql .= " sort_order = :sort_order,";
    if (isset($product['is_deleted'])) $sql .= " is_deleted = :is_deleted,";

    $sql = rtrim($sql, ",");

    $sql .= " WHERE slug = :slug";

    $params = array();
    if (isset($product['slug'])) $params[":slug"] = $product['slug'];
    if (isset($product['name'])) $params[":name"] = $product['name'];
    if (isset($product['description'])) $params[":description"] = $product['description'];
    if (isset($product['price'])) $params[":price"] = $product['price'];
    if (isset($product['is_highlander'])) $params[":is_highlander"] = $product['is_highlander'];
    if (isset($product['stock_quantity'])) $params[":stock_quantity"] = $product['stock_quantity'];
    if (isset($product['sort_order'])) $params[":sort_order"] = $product['sort_order'];
    if (isset($product['is_deleted'])) $params[":is_deleted"] = $product['is_deleted'];

    $result = Database::queryInsert($sql, $params);

    if ($result['lastInsertId'] || $result['success']) {
        log_txt("Product updated in back office: slug " . $product['slug']);
        return true;
    } else {
        return false;
    }
}

function updateProductCategories($product_slug, $categories)
{
    // check if given array is not full of empty strings
    if (count(array_filter($categories)) == 0) {
        return false;
    }

    // Delete all categories for this prBF05W1HU5Joduct
    $sql = "UPDATE product_category SET is_deleted = 1 WHERE product_slug = :product_slug";

    $result = Database::queryUpdate($sql, array(":product_slug" => $product_slug));

    if ($result['success']) {
        log_txt("Product categories deleted in back office: slug " . $product_slug);
    } else {
        return false;
    }

    // Insert all categories for this product
    $sql = "INSERT INTO product_category (product_slug, category_slug) VALUES (:product_slug, :category_slug)";
    foreach ($categories as $key => $value) {
        $result = Database::queryInsert($sql, array(":product_slug" => $product_slug, ":category_slug" => $value));
        if ($result['success']) {
            log_txt("Product categories inserted in back office: slug " . $product_slug);
        } else {
            return false;
        }
    }

    return true;
}

function updateProductMaterials($product_slug, $materials)
{
    // check if given array is not full of empty strings
    if (count(array_filter($materials)) == 0) {
        return false;
    }

    // Delete all materials for this product
    $sql = "UPDATE product_material SET is_deleted = 1 WHERE product_slug = :product_slug";

    $result = Database::queryUpdate($sql, array(":product_slug" => $product_slug));

    if ($result['success']) {
        log_txt("Product materials deleted in back office: slug " . $product_slug);
    } else {
        return false;
    }

    // Insert all materials for this product
    $sql = "INSERT INTO product_material (product_slug, material_slug) VALUES (:product_slug, :material_slug)";
    foreach ($materials as $key => $value) {
        $result = Database::queryInsert($sql, array(":product_slug" => $product_slug, ":material_slug" => $value));
        if ($result['success']) {
            log_txt("Product materials inserted in back office: slug " . $product_slug);
        } else {
            return false;
        }
    }

    return true;
}

function updateProductImages($product_slug, $images)
{
    // check if given array is not full of empty strings
    if (count(array_filter($images)) == 0) {
        return false;
    }


    // Delete all images for this product
    $sql = "UPDATE product_image SET is_deleted = 1 WHERE product_slug = :product_slug";

    $result = Database::queryUpdate($sql, array(":product_slug" => $product_slug));

    if ($result['success']) {
        log_txt("Product images deleted in back office: slug " . $product_slug);
    } else {
        return false;
    }

    // Insert all images for this product
    $sql = "INSERT INTO product_image (product_slug, image_slug) VALUES (:product_slug, :image_slug)";
    foreach ($images as $key => $value) {
        $result = Database::queryInsert($sql, array(":product_slug" => $product_slug, ":image_slug" => $value));
        if ($result['success']) {
            log_txt("Product images inserted in back office: slug " . $product_slug);
        } else {
            return false;
        }
    }

    return true;
}

function putToTrashProduct($slug)
{
    $sql = "UPDATE product SET is_deleted = 1 WHERE slug = :slug";

    $params = array(":slug" => $slug);

    $result = Database::queryUpdate($sql, $params);

    if ($result['success']) {
        log_txt("Product deleted in back office: slug " . $slug);
        return true;
    } else {
        return false;
    }
}
