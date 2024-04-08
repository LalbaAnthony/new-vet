<?php

include_once "../../config.inc.php";
include_once APP_PATH . '/models/customer.php';
include_once APP_PATH . '/helpers/token_gen.php';

$email = isset($_GET['email']) ? $_GET['email'] : '';
$password = isset($_GET['password']) ? $_GET['password'] : '';

$error = null;
$json = array();
$customer = array();

// check if param is set
if (!$email) $error = "Missing email";
if (!$password) $error = "Missing password";

// Check if email already exists
if (!$error) {
    setConnectionTokenByEmail($email);
    $customer = getCustomerByEmail($email);
}

// Check if email exists
if (!$error && !$customer) $error = "Aucun utilisateur trouvé";

// Check if password is correct
if (!$error && !password_verify($password, $customer["password"])) $error = "Le mot de passe est incorrect";

// Remove password from response
if (!$error) unset($customer["password"]);

// send contact to db
if (!$error) {
    $json['status'] = 200;
    $json['error'] = null;
    $json['data'] = array($customer);
} else {
    $json['status'] = 400;
    $json['error'] = $error;
}

// Return  JSON
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-type: application/json; charset=utf-8");

$json = json_encode($json);
echo $json;
