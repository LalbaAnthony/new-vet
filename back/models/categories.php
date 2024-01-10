<?php

require_once('base.php');

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
