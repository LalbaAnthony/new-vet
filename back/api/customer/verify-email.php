<?php

require_once "../../config.inc.php";
include_once APP_PATH . 'models/customer.php';
include_once APP_PATH . 'helpers/token_gen.php';

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
if (!$error && $token !== $customer["validate_email_token"]) $error = "Le token du lien est invalide";

if (!$error) {
    setHasValidateEmail($email, true);
    clearCodesAndTokens($customer["customer_id"], array('validate_email_token'));
}

// send contact to db
if (!$error) {
    $json['status'] = 200;
    $json['error'] = null;
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
