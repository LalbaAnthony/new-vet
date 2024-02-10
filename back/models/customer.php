<?php

function getCustomer($customer_id)
{
    $dbh = db_connect();

    $sql = "SELECT * FROM customer WHERE customer_id = :customer_id";

    try {
        $sth = $dbh->prepare($sql);
        $sth->execute(array(":customer_id" => $customer_id));
        $customer = $sth->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Erreur lors de la requête SQL : " . $e->getMessage());
    }

    return $customer;
}

function getCustomers()
{
    $dbh = db_connect();

    $sql = "SELECT * FROM customer WHERE is_deleted = 0 ORDER BY created_at DESC";

    try {
        $sth = $dbh->prepare($sql);
        $sth->execute();
        $customers = $sth->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Erreur lors de la requête SQL : " . $e->getMessage());
    }

    return $customers;
}
