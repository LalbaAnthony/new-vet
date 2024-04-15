<?php

include_once APP_PATH . '/helpers/slugify.php';

function getOrder($order_id)
{
    $dbh = db_connect();
    $sql = "SELECT * FROM `order` WHERE order_id = :order_id;";
    try {
        $sth = $dbh->prepare($sql);
        $sth->execute(array(":order_id" => $order_id));
        $order = $sth->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Erreur lors de la requête SQL #534: " . $e->getMessage());
    }

    return $order;
}

function getOrders($date_start = null, $date_end = null, $search = null, $customer_id = null, $sort =  array(array('order' => 'DESC', 'order_by' => 'order_date')), $offset = null, $per_page = 10)
{

    $dbh = db_connect();

    // Select all orders, with their categories and materials (we use LEFT JOIN to get orders without categories or materials)
    $sql = "SELECT `order`.* FROM `order`
    LEFT JOIN status ON status.status_id = `order`.status_id
    LEFT JOIN order_line ON order_line.order_id = `order`.order_id
    LEFT JOIN product ON order_line.product_slug = product.slug
    LEFT JOIN product_category ON product_category.product_slug = product.slug
    LEFT JOIN category ON product_category.category_slug = category.slug
    LEFT JOIN product_material ON product_material.product_slug = product.slug
    LEFT JOIN material ON product_material.material_slug = material.slug";

    // Use WHERE 1 = 1 to be able to add conditions with AND
    $sql .= " WHERE 1 = 1";

    $sql .= " AND `order`.is_deleted = 0";

    // Filter by date
    if ($date_start) $sql .= " AND `order`.order_date >= :date_start";
    if ($date_end) $sql .= " AND `order`.order_date <= :date_end";

    // Filter by customer_id
    if ($customer_id) $sql .= " AND `order`.customer_id = :customer_id";

    // Filter by search
    if ($search) {
        $sql .= " AND (
        product.slug LIKE :search OR 
        product.name LIKE :search OR
        product.description LIKE :search OR
        product.price LIKE :search OR
        category.slug LIKE :search OR
        material.slug LIKE :search OR
        category.libelle LIKE :search OR
        material.libelle LIKE :search OR
        SOUNDEX(product.name) = SOUNDEX(:search) OR
        SOUNDEX(product.description) = SOUNDEX(:search) OR
        SOUNDEX(product.price) = SOUNDEX(:search) OR
        SOUNDEX(category.libelle) = SOUNDEX(:search) OR
        SOUNDEX(material.libelle) = SOUNDEX(:search)
    )";
    }

    // Sort
    if ($sort) {
        $sql .= " ORDER BY ";
        foreach ($sort as $key => $value) {
            $sql .= "COALESCE(`order`." . $value['order_by'] . ", 9999999) " . strtoupper($value['order']); // COALESCE to avoid NULL values
            if ($key < count($sort) - 1) $sql .= ", ";
        }
    }

    // Limit and offset
    if ($per_page) $sql .= " LIMIT :per_page";
    if ($offset) $sql .= " OFFSET :offset";

    try {
        $sth = $dbh->prepare($sql);

        // Bind values
        if ($date_start) $sth->bindValue(":date_start", $date_start);
        if ($date_end) $sth->bindValue(":date_end", $date_end);
        if ($customer_id) $sth->bindValue(":customer_id", $customer_id);
        if ($search) $sth->bindValue(":search", "%$search%");
        if ($per_page) $sth->bindValue(":per_page", $per_page, PDO::PARAM_INT);
        if ($offset) $sth->bindValue(":offset", $offset, PDO::PARAM_INT);

        $sth->execute();

        $orders = $sth->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Erreur lors de la requête SQL #901: " . $e->getMessage());
    }

    return $orders;
}

function getOrdersCount($date_start = null, $date_end = null, $search = null, $customer_id = null)
{
    $dbh = db_connect();

    // Select all orders, with their categories and materials (we use LEFT JOIN to get orders without categories or materials)
    $sql = "SELECT COUNT(*) as count FROM `order`
    LEFT JOIN status ON status.status_id = `order`.status_id
    LEFT JOIN order_line ON order_line.order_id = `order`.order_id
    LEFT JOIN product ON order_line.product_slug = product.slug
    LEFT JOIN product_category ON product_category.product_slug = product.slug
    LEFT JOIN category ON product_category.category_slug = category.slug
    LEFT JOIN product_material ON product_material.product_slug = product.slug
    LEFT JOIN material ON product_material.material_slug = material.slug";

    // Use WHERE 1 = 1 to be able to add conditions with AND
    $sql .= " WHERE 1 = 1";

    $sql .= " AND `order`.is_deleted = 0";

    // Filter by date
    if ($date_start) $sql .= " AND `order`.order_date >= :date_start";
    if ($date_end) $sql .= " AND `order`.order_date <= :date_end";

    // Filter by customer_id
    if ($customer_id) $sql .= " AND `order`.customer_id = :customer_id";

    // Filter by search
    if ($search) {
        $sql .= " AND (
        product.slug LIKE :search OR 
        product.name LIKE :search OR
        product.description LIKE :search OR
        product.price LIKE :search OR
        category.slug LIKE :search OR
        material.slug LIKE :search OR
        category.libelle LIKE :search OR
        material.libelle LIKE :search OR
        SOUNDEX(product.name) = SOUNDEX(:search) OR
        SOUNDEX(product.description) = SOUNDEX(:search) OR
        SOUNDEX(product.price) = SOUNDEX(:search) OR
        SOUNDEX(category.libelle) = SOUNDEX(:search) OR
        SOUNDEX(material.libelle) = SOUNDEX(:search)
    )";
    }

    try {
        $sth = $dbh->prepare($sql);

        // Bind values
        if ($date_start) $sth->bindValue(":date_start", $date_start);
        if ($date_end) $sth->bindValue(":date_end", $date_end);
        if ($customer_id) $sth->bindValue(":customer_id", $customer_id);
        if ($search) $sth->bindValue(":search", "%$search%");
        $sth->execute();

        $count = $sth->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Erreur lors de la requête SQL #991: " . $e->getMessage());
    }

    return $count['count'];
}

function getOrderLines($order_id)
{
    $dbh = db_connect();
    $sql = "SELECT * FROM order_line WHERE order_id = :order_id AND is_deleted = 0;";
    try {
        $sth = $dbh->prepare($sql);
        $sth->execute(array(":order_id" => $order_id));
        $order_lines = $sth->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Erreur lors de la requête SQL #504: " . $e->getMessage());
    }

    return $order_lines;
}

function deleteOrder($order_id)
{
    $dbh = db_connect();
    $sql = "UPDATE `order` SET is_deleted = 1 WHERE order_id = :order_id;";
    try {
        $sth = $dbh->prepare($sql);
        $sth->execute(array(":order_id" => $order_id));
    } catch (PDOException $e) {
        die("Erreur lors de la requête SQL #351: " . $e->getMessage());
    }
}
