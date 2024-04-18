<?php

require_once "../../config.inc.php";
include_once APP_PATH . 'controllers/customer.php';
include_once APP_PATH . 'helpers/code_gen.php';

$email = isset($_GET['email']) ? $_GET['email'] : '';

$error = null;
$json = array();
$customer = array();

// check if param is set
if (!$email) $error = "Missing email";

// Get user
if (!$error) {
    $customer = getCustomerByEmail($email);
}

// Check if email exists
if (!$error && !$customer) $error = "Aucun utilisateur trouvé";

if (!$error) {
    setResetPasswordCodeByEmail($email);
    // TODO: send email with code here
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
