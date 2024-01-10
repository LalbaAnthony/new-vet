<?php

function db_connect()
{
    $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME;
    try {
        $dbh = new PDO($dsn, DB_USER, DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $ex) {
        die("Erreur lors de la connexion à la base de donnée : " . $ex->getMessage());
    }
    return $dbh;
}

function getProducts($category_slug = null)
{
    $dbh = db_connect();

    if ($category_slug) {
        $sql = "SELECT * FROM product WHERE category_slug = :category_slug ORDER BY created_at DESC;";
    } else {
        $sql = "SELECT * FROM product ORDER BY created_at DESC;";
    }

    try {
        $sth = $dbh->prepare($sql);
        if ($category_slug) {
            $sth->execute(array(":category_slug" => $category_slug));
        } else {
            $sth->execute();
        }
        $products = $sth->fetchAll(PDO::FETCH_ASSOC);
        log_txt("Read products");
    } catch (PDOException $e) {
        die("Erreur lors de la requête SQL : " . $e->getMessage());
    }

    return $products;
}

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

function deleteProduct($slug)
{
    $dbh = db_connect();
    $sql = "DELETE FROM product WHERE slug = :slug;";
    try {
        $sth = $dbh->prepare($sql);
        $sth->execute(array(":slug" => $slug));
        log_txt("Product deleted: slug $slug");
    } catch (PDOException $e) {
        die("Erreur lors de la requête SQL : " . $e->getMessage());
    }
}

// function insertProduct($content)
// {
//     $dbh = db_connect();
//     $sql = "INSERT INTO product (title, slug, content, created_at) VALUES (:title, :slug, :content, NOW());";
//     try {
//         $sth = $dbh->prepare($sql);
//         $sth->execute(array(
//             ":title" => $content['title'],
//             ":slug" => $content['slug'],
//             ":content" => $content['content']
//         ));
//         log_txt("Product inserted: slug " . $content['slug']);
//     } catch (PDOException $e) {
//         die("Erreur lors de la requête SQL : " . $e->getMessage());
//     }
// }

function getImages($product_slug)
{
    $dbh = db_connect();
    $sql = "SELECT * FROM image WHERE product_slug = :product_slug ORDER BY created_at DESC;";
    try {
        $sth = $dbh->prepare($sql);
        $sth->execute(array(":product_slug" => $product_slug));
        $images = $sth->fetchAll(PDO::FETCH_ASSOC);
        log_txt("Read images of product: slug $product_slug");
    } catch (PDOException $e) {
        die("Erreur lors de la requête SQL : " . $e->getMessage());
    }

    return $images;
}

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