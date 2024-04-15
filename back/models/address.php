<?php

function getAddress($address_id)
{
    $dbh = db_connect();
    $sql = "SELECT * FROM address WHERE address_id = :address_id;";
    try {
        $sth = $dbh->prepare($sql);
        $sth->execute(array(":address_id" => $address_id));
        $address = $sth->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Erreur lors de la requête SQL #121: " . $e->getMessage());
    }

    return $address;
}

function getAddresses($customer_id = null, $search = null)
{
    $dbh = db_connect();

    // Select all addresses
    $sql = "SELECT * FROM address";

    $sql .= " WHERE is_deleted = 0";

    // Filter by customer_id
    if ($customer_id) $sql .= " AND customer_id = :customer_id";

    // Filter by search
    if ($search) $sql .= " AND (first_name LIKE :search OR last_name LIKE :search OR address1 LIKE :search OR address2 LIKE :search OR city LIKE :search OR region LIKE :search OR postal_code LIKE :search OR tel LIKE :search)";
    
    $sql .= " ORDER BY sort_order ASC";

    try {
        $sth = $dbh->prepare($sql);

        // Bind values
        if ($customer_id) $sth->bindValue(":customer_id", $customer_id);
        if ($search) $sth->bindValue(":search", "%$search%");

        $sth->execute();

        $addresses = $sth->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Erreur lors de la requête SQL #131: " . $e->getMessage());
    }

    return $addresses;
}

function insertAddress($address)
{
    $dbh = db_connect();

    $sql = "INSERT INTO address (customer_id, first_name, last_name, address1, address2, city, region, postal_code, country_id, tel) VALUES (:customer_id, :first_name, :last_name, :address1, :address2, :city, :region, :postal_code, :country_id, :tel)";

    try {
        $sth = $dbh->prepare($sql);
        $sth->execute(array(":customer_id" => $address['customer_id'], ":first_name" => $address['first_name'], ":last_name" => $address['last_name'], ":address1" => $address['address1'], ":address2" => $address['address2'], ":city" => $address['city'], ":region" => $address['region'], ":postal_code" => $address['postal_code'], ":country_id" => $address['country_id'], ":tel" => $address['tel']));
        if ($sth->rowCount() > 0) {
            log_txt("Address registered in back office: address_id " . $dbh->lastInsertId());
            return $dbh->lastInsertId();
        } else {
            return false;
        }
    } catch (PDOException $e) {
        die("Erreur lors de la requête SQL #141: " . $e->getMessage());
    }
}

function updateAddress($address)
{
    $dbh = db_connect();

    $sql = "UPDATE address SET customer_id = :customer_id, first_name = :first_name, last_name = :last_name, address1 = :address1, address2 = :address2, city = :city, region = :region, postal_code = :postal_code, country_id = :country_id, tel = :tel WHERE address_id = :address_id";

    try {
        $sth = $dbh->prepare($sql);
        $sth->execute(array(":customer_id" => $address['customer_id'], ":first_name" => $address['first_name'], ":last_name" => $address['last_name'], ":address1" => $address['address1'], ":address2" => $address['address2'], ":city" => $address['city'], ":region" => $address['region'], ":postal_code" => $address['postal_code'], ":country_id" => $address['country_id'], ":tel" => $address['tel'], ":address_id" => $address['address_id']));
        if ($sth->rowCount() > 0) {
            log_txt("Address updated in back office: address_id " . $address['address_id']);
            return true;
        } else {
            return false;
        }
    } catch (PDOException $e) {
        die("Erreur lors de la requête SQL #151: " . $e->getMessage());
    }
}


function deleteAddress($address_id)
{
    $dbh = db_connect();

    $sql = "UPDATE address SET is_deleted = 1 WHERE address_id = :address_id";

    try {
        $sth = $dbh->prepare($sql);
        $sth->execute(array(":address_id" => $address_id));
        if ($sth->rowCount() > 0) {
            log_txt("Address deleted in back office: address_id " . $address_id);
            return true;
        } else {
            return false;
        }
    } catch (PDOException $e) {
        die("Erreur lors de la requête SQL #161: " . $e->getMessage());
    }
}
