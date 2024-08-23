<?php

require_once "../../config.inc.php";
include_once APP_PATH . 'controllers/customer.php';

$email = isset($_GET['email']) ? $_GET['email'] : '';
$token = isset($_GET['token']) ? $_GET['token'] : '';

$error = null;
$json = array();
$customer = array();

// check if param is set
if (!$email) $error = "Missing email";
if (!$token) $error = "Missing token";

// Get user
if (!$error) {
    $customer = getCustomerByEmail($email);
}

// Check if email exists
if (!$error && !$customer) $error = "Aucun utilisateur trouvé";

// Check if token is correct
if (!$error && $token !== $customer["connection_token"]) $error = "Invalid token";

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
