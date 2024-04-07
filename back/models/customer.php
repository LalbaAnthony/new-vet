<?php

function setConnectionTokenByEmail($email, $token = null)
{
    if ($token === null) $token = token_gen(32);
    $dbh = db_connect();
    $sql = "UPDATE customer SET connection_token = :connection_token WHERE email = :email";
    try {
        $sth = $dbh->prepare($sql);
        $sth->execute(array(":connection_token" => $token, ":email" => $email));
    } catch (PDOException $e) {
        die("Erreur lors de la requête SQL #987: " . $e->getMessage());
    }
}

function setValidateEmailTokenByEmail($email, $token = null)
{
    if ($token === null) $token = token_gen(32);
    $dbh = db_connect();
    $sql = "UPDATE customer SET validate_email_token = :validate_email_token WHERE email = :email";
    try {
        $sth = $dbh->prepare($sql);
        $sth->execute(array(":validate_email_token" => $token, ":email" => $email));
    } catch (PDOException $e) {
        die("Erreur lors de la requête SQL #997: " . $e->getMessage());
    }
}

function setResetPasswordTokenByEmail($email, $token = null)
{
    if ($token === null) $token = token_gen(32);
    $dbh = db_connect();
    $sql = "UPDATE customer SET reset_password_token = :reset_password_token WHERE email = :email";
    try {
        $sth = $dbh->prepare($sql);
        $sth->execute(array(":reset_password_token" => $token, ":email" => $email));
    } catch (PDOException $e) {
        die("Erreur lors de la requête SQL #697: " . $e->getMessage());
    }
}

function clearTokens($id, $tokenList = null)
{
    $possibleTokens = array('connection_token', 'validate_email_token', 'reset_password_token');

    // If no token list is provided, clear all possible tokens
    if (!$tokenList) $tokenList = $possibleTokens;

    // Check if each token is in the list
    foreach ($tokenList as $token) {
        if (!in_array($token, $possibleTokens)) {
            return;
        }
    }

    $dbh = db_connect();

    $sql = "UPDATE customer SET";
    foreach ($tokenList as $token) {
        $sql .= " $token = NULL,";
    }
    $sql = substr($sql, 0, -1); // remove last comma
    $sql .= " WHERE customer_id = :customer_id";

    try {
        $sth = $dbh->prepare($sql);
        $sth->execute(array(":customer_id" => $id));
    } catch (PDOException $e) {
        die("Erreur lors de la requête SQL #987: " . $e->getMessage());
    }
}

function setValidateEmail($email, $validate = true)
{
    $dbh = db_connect();
    $sql = "UPDATE customer SET has_validated_email = :has_validated_email WHERE email = :email";
    try {
        $sth = $dbh->prepare($sql);
        $sth->execute(array(":has_validated_email" => $validate, ":email" => $email));
    } catch (PDOException $e) {
        die("Erreur lors de la requête SQL #977: " . $e->getMessage());
    }
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
