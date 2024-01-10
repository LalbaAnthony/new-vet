<?php

function getCountry($country_id)
{
    $dbh = db_connect();
    $sql = "SELECT * FROM country WHERE country_id = :country_id;";
    try {
        $sth = $dbh->prepare($sql);
        $sth->execute(array(":country_id" => $country_id));
        $country = $sth->fetch(PDO::FETCH_ASSOC);
        log_txt("Read country: slug $country_id");
    } catch (PDOException $e) {
        die("Erreur lors de la requête SQL : " . $e->getMessage());
    }

    return $country;
}

function getCountries($order_by = 'name', $order = 'ASC')
{
    $dbh = db_connect();

    // Select all countries
    $sql = "SELECT * FROM country";

    $sql .= " ORDER BY :order_by :order";

    try {
        $sth = $dbh->prepare($sql);

        // Bind values
        $sth->bindValue(":order_by", $order_by);
        $sth->bindValue(":order", $order);

        $sth->execute();

        $countries = $sth->fetchAll(PDO::FETCH_ASSOC);
        log_txt("Read countries");
    } catch (PDOException $e) {
        die("Erreur lors de la requête SQL : " . $e->getMessage());
    }

    return $countries;
}