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

function getCustomerByEmail($email)
{
    $dbh = db_connect();

    $sql = "SELECT * FROM customer WHERE email = :email";

    try {
        $sth = $dbh->prepare($sql);
        $sth->execute(array(":email" => $email));
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

function getCustomersCount() {
    $dbh = db_connect();
    $sql = "SELECT COUNT(*) FROM customer WHERE is_deleted = 0";
    try {
        $sth = $dbh->prepare($sql);
        $sth->execute();
        $count = $sth->fetchColumn();
    } catch (PDOException $e) {
        die("Erreur lors de la requête SQL : " . $e->getMessage());
    }

    return $count;
}

function insertCustomer($customer)
{
    $dbh = db_connect();

    $sql = "INSERT INTO customer (first_name, last_name, email, password) VALUES (:first_name, :last_name, :email, :password)";

    try {
        $sth = $dbh->prepare($sql);
        $sth->execute(array(":first_name" => $customer['first_name'], ":last_name" => $customer['last_name'], ":email" => $customer['email'], ":password" => $customer['password']));
    } catch (PDOException $e) {
        return "Erreur lors de la requête SQL : " . $e->getMessage();
    }
}

function deleteCustomer($customer_id)
{
    $dbh = db_connect();

    $sql = "UPDATE customer SET is_deleted = 1 WHERE customer_id = :customer_id";

    try {
        $sth = $dbh->prepare($sql);
        $sth->execute(array(":customer_id" => $customer_id));
    } catch (PDOException $e) {
        die("Erreur lors de la requête SQL : " . $e->getMessage());
    }
}