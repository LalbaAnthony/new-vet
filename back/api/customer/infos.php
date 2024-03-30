<?php

include_once "../../config.inc.php";
include_once APP_PATH . '/models/customer.php';

$email = isset($_GET['email']) ? $_GET['email'] : '';
$token = isset($_GET['token']) ? $_GET['token'] : '';

$error = null;
$json = array();
$customer = array();

// check if param is set
if (!$email) $error = "Missing email";
if (!$token) $error = "Missing token";

// Check if email already exists
if (!$error) {
    $customer = getCustomerByEmail($email);
}

// Check if email exists
if (!$error && !$customer) $error = "Customer not found";

// Check if token is correct
if (!$error && $token !== $customer["connection_token"]) $error = "Invalid token";

// Remove token from response
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
