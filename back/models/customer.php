<?php

function setConnectionTokenByEmail($email, $token = null)
{
    if ($token == null) $token = token_gen(32);
    $dbh = db_connect();
    $sql = "UPDATE customer SET connection_token = :connection_token WHERE email = :email";
    try {
        $sth = $dbh->prepare($sql);
        $sth->execute(array(":connection_token" => $token, ":email" => $email));
    } catch (PDOException $e) {
        die("Erreur lors de la requête SQL #28: " . $e->getMessage());
    }
}

function isTokenOk($email, $token)
{
    if (!$token) return false;
    $dbh = db_connect();
    $sql = "SELECT * FROM customer WHERE email = :email";
    try {
        $sth = $dbh->prepare($sql);
        $sth->execute(array(":email" => $email, ":connection_token" => $token));
        $customer = $sth->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Erreur lors de la requête SQL #29: " . $e->getMessage());
    }

    if ($customer && $customer['connection_token'] == $token) return true;
    return false;
}

function changePassword($id, $password)
{
    $dbh = db_connect();
    $sql = "UPDATE customer SET password = :password WHERE customer_id = :customer_id";
    try {
        $sth = $dbh->prepare($sql);
        $sth->execute(array(":password" => $password, ":customer_id" => $id));
    } catch (PDOException $e) {
        die("Erreur lors de la requête SQL #28: " . $e->getMessage());
    }
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
        die("Erreur lors de la requête SQL #29: " . $e->getMessage());
    }

    return $customer;
}

function getCustomer($customer_id)
{
    $dbh = db_connect();

    $sql = "SELECT * FROM customer WHERE customer_id = :customer_id";

    try {
        $sth = $dbh->prepare($sql);
        $sth->execute(array(":customer_id" => $customer_id));
        $customer = $sth->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Erreur lors de la requête SQL #30: " . $e->getMessage());
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
        die("Erreur lors de la requête SQL #31: " . $e->getMessage());
    }

    return $customers;
}

function getCustomersCount()
{
    $dbh = db_connect();
    $sql = "SELECT COUNT(*) FROM customer WHERE is_deleted = 0";
    try {
        $sth = $dbh->prepare($sql);
        $sth->execute();
        $count = $sth->fetchColumn();
    } catch (PDOException $e) {
        die("Erreur lors de la requête SQL #32: " . $e->getMessage());
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
        return "Erreur lors de la requête SQL #33: " . $e->getMessage();
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
        die("Erreur lors de la requête SQL #34: " . $e->getMessage());
    }
}
