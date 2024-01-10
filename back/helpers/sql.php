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

function getProducts()
{
    $dbh = db_connect();
    $sql = "SELECT * FROM product WHERE deleted <> 1 ORDER BY created_at DESC;";
    try {
        $sth = $dbh->prepare($sql);
        $sth->execute();
        $products = $sth->fetchAll(PDO::FETCH_ASSOC);
        log_txt("Read products");
    } catch (PDOException $e) {
        die("Erreur lors de la requête SQL : " . $e->getMessage());
    }

    return $products;
}

function deleteProduct($id)
{
    $dbh = db_connect();
    $sql = "UPDATE product SET deleted = 1 WHERE id = :id;";
    try {
        $sth = $dbh->prepare($sql);
        $sth->execute(array(":id" => $id));
        log_txt("Product deleted: id $id");
    } catch (PDOException $e) {
        die("Erreur lors de la requête SQL : " . $e->getMessage());
    }
}

function insertProduct($content)
{
    $dbh = db_connect();
    $sql = "INSERT INTO product (content, color) VALUES (:content, :color);";
    try {
        $sth = $dbh->prepare($sql);
        $sth->execute(array(":content" => $content, ":color" => getRandomColor()));
        log_txt("Product inserted");
    } catch (PDOException $e) {
        die("Erreur lors de la requête SQL : " . $e->getMessage());
    }
}
