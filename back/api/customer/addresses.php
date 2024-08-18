
<?php

require_once "../../config.inc.php";
include_once APP_PATH . 'controllers/customer.php';
include_once APP_PATH . 'controllers/address.php';

$customer_id = isset($_GET['customer_id']) ? $_GET['customer_id'] : '';
$search = isset($_GET['search']) ? $_GET['customer_id'] : '';
$token = isset($_GET['token']) ? $_GET['token'] : '';

$error = null;
$json = array();
$addresses = array();

// check if param is set
if (!$customer_id) $error = "Missing customer_id";
if (!$token) $error = "Missing token";

// Get user
if (!$error) {
    $customer = getCustomer($customer_id);
}
// Check if user exists
if (!$error && !$customer) $error = "Aucun utilisateur trouvé";

// Check if token is correct
if (!$error && $token !== $customer["connection_token"]) $error = "Invalid token";

// Get addresses
if (!$error) $addresses = getAddresses($customer_id, $search);

if (count($addresses) > 0) {
    $json['status'] = 200;
    $json['error'] = null;
    $json['data'] = $addresses;
} else if (count($addresses) === 0) {
    $json['status'] = 400;
    $json['error'] = 'No element found';
    $json['data'] = array();
} else {
    $json['status'] = 500;
    $json['error'] = 'Error while getting elements';
}

// Return  JSON
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-type: application/json; charset=utf-8");

$json = json_encode($json);
echo $json;
