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

function insertCountry($country)
{
    $dbh = db_connect();

    $sql = "INSERT INTO country (name) VALUES (:name)";

    try {
        $sth = $dbh->prepare($sql);
        $sth->execute(array(":name" => $country['name']));
        if ($sth->rowCount() > 0) {
            log_txt("Country registered in back office: name " . $country['name']);
            return true;
        } else {
            return false;
        }
    } catch (PDOException $e) {
        die("Erreur lors de la requête SQL : " . $e->getMessage());
    }
}

function updateCountry($country)
{
    $dbh = db_connect();

    $sql = "UPDATE country SET name = :name, WHERE country_id = :country_id";

    try {
        $sth = $dbh->prepare($sql);
        $sth->execute(array(":name" => $country['name'], ":country_id" => $country['country_id']));
        if ($sth->rowCount() > 0) {
            log_txt("Country updated in back office: country_id " . $country['country_id']);
            return true;
        } else {
            return false;
        }
    } catch (PDOException $e) {
        die("Erreur lors de la requête SQL : " . $e->getMessage());
    }
}

function deleteCountry($country_id)
{
    $dbh = db_connect();

    $sql = "DELETE FROM country WHERE country_id = :country_id";

    try {
        $sth = $dbh->prepare($sql);
        $sth->execute(array(":country_id" => $country_id));
        if ($sth->rowCount() > 0) {
            log_txt("Country deleted in back office: country_id " . $country_id);
            return true;
        } else {
            return false;
        }
    } catch (PDOException $e) {
        die("Erreur lors de la requête SQL : " . $e->getMessage());
    }
}