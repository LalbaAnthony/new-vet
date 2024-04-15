<?php

function setConnectionTokenByEmail($email, $token = null)
{
    if ($token === null) $token = token_gen(32);
    $sql = "UPDATE customer SET connection_token = :connection_token WHERE email = :email";

    $result = Database::queryUpdate($sql, array(":connection_token" => $token, ":email" => $email));

    if ($result['success']) {
        log_txt("Connection token set in customer: email $email token $token");
        return true;
    } else {
        return false;
    }
}

function setHasValidateEmailTokenByEmail($email, $token = null)
{
    if ($token === null) $token = token_gen(32);
    $sql = "UPDATE customer SET validate_email_token = :validate_email_token WHERE email = :email";

    $result = Database::queryUpdate($sql, array(":validate_email_token" => $token, ":email" => $email));

    if ($result['success']) {
        log_txt("Validate email token set in customer: email $email token $token");
        return true;
    } else {
        return false;
    }
}

function setResetPasswordCodeByEmail($email, $code = null)
{
    if ($code === null) $code = code_gen(6);
    $sql = "UPDATE customer SET reset_password_code = :reset_password_code WHERE email = :email";

    $result = Database::queryUpdate($sql, array(":reset_password_code" => $code, ":email" => $email));

    if ($result['success']) {
        log_txt("Reset password code set in customer: email $email code $code");
        return true;
    } else {
        return false;
    }
}

function clearCodesAndTokens($customer_id, $tokenList = null)
{
    $possibleTokens = array('connection_token', 'validate_email_token', 'reset_password_code');

    // If no token list is provided, clear all possible tokens
    if (!$tokenList) $tokenList = $possibleTokens;

    // Check if each token is in the list
    foreach ($tokenList as $token) {
        if (!in_array($token, $possibleTokens)) {
            return;
        }
    }


    $sql = "UPDATE customer SET";
    foreach ($tokenList as $token) {
        $sql .= " $token = NULL,";
    }
    $sql = substr($sql, 0, -1); // remove last comma
    $sql .= " WHERE customer_id = :customer_id";

    $result = Database::queryUpdate($sql, array(":customer_id" => $customer_id));

    if ($result['success']) {
        log_txt("Codes and tokens cleared in customer: customer_id $customer_id");
        return true;
    } else {
        return false;
    }
}

function setHasValidateEmail($email, $validate = true)
{
    $sql = "UPDATE customer SET has_validated_email = :has_validated_email WHERE email = :email";

    $result = Database::queryUpdate($sql, array(":has_validated_email" => $validate, ":email" => $email));

    if ($result['success']) {
        log_txt("Has validated email set in customer: email $email has_validated_email $validate");
        return true;
    } else {
        return false;
    }
}

function autoUpdateLastLoginCustomer($customer_id, $datetime = null)
{
    if (!$datetime) $datetime = date("Y-m-d H:i:s");


    $sql = "UPDATE customer SET last_login = :datetime WHERE customer_id = :customer_id";

    $result = Database::queryUpdate($sql, array(":datetime" => $datetime, ":customer_id" => $customer_id));

    if ($result['success']) {
        log_txt("Customer last login updated in back office: customer_id $customer_id last_login $datetime");
        return true;
    } else {
        return false;
    }
}

function changePassword($customer_id, $password)
{
    $sql = "UPDATE customer SET password = :password WHERE customer_id = :customer_id";

    $result = Database::queryUpdate($sql, array(":password" => $password, ":customer_id" => $customer_id));

    if ($result['success']) {
        log_txt("Password changed in customer: customer_id $customer_id");
        return true;
    } else {
        return false;
    }
}

function getCustomerByEmail($email)
{

    $sql = "SELECT * FROM customer WHERE email = :email";
    
    $result = Database::queryOne($sql, array(":email" => $email));

    return $result['data'];
}

function getCustomer($customer_id)
{

    $sql = "SELECT * FROM customer WHERE customer_id = :customer_id";
    
    $result = Database::queryOne($sql, array(":customer_id" => $customer_id));

    return $result['data'];
}

function getCustomers()
{

    $sql = "SELECT * FROM customer WHERE is_deleted = 0 ORDER BY created_at DESC";

    $result = Database::queryAll($sql);

    return $result['data'];
}

function getCustomersCount()
{
    $sql = "SELECT COUNT(*) as count FROM customer WHERE is_deleted = 0";
    
    $result = Database::queryOne($sql);

    return $result['data']['count'];
}

function insertCustomer($customer)
{

    $sql = "INSERT INTO customer (first_name, last_name, email, password) VALUES (:first_name, :last_name, :email, :password)";

    $result = Database::queryInsert($sql, array(":first_name" => $customer['first_name'], ":last_name" => $customer['last_name'], ":email" => $customer['email'], ":password" => $customer['password']));

    if ($result['lastInsertId']) {
        log_txt("Customer inserted in back office: customer_id " . $result['lastInsertId']);
        return $result;
    } else {
        return false;
    }
}

function deleteCustomer($customer_id)
{

    $sql = "UPDATE customer SET is_deleted = 1 WHERE customer_id = :customer_id";

    $result = Database::queryUpdate($sql, array(":customer_id" => $customer_id));

    if ($result['success']) {
        log_txt("Customer deleted in back office: customer_id " . $customer_id);
        return true;
    } else {
        return false;
    }
}
