
<?php

require_once "../../config.inc.php";
include_once APP_PATH . 'controllers/customer.php';
include_once APP_PATH . 'controllers/card.php';

$customer_id = isset($_GET['customer_id']) ? $_GET['customer_id'] : '';
$token = isset($_GET['token']) ? $_GET['token'] : '';

$error = null;
$json = array();
$cards = array();

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

// Get cards
if (!$error) $cards = getCards($customer_id);

// Hide card number
if (!$error && count($cards) > 0) {
    foreach ($cards as $key => $card) {
        $cards[$key]['number'] = "************" . substr($card['number'], -4);
    }
}


if ($error) {
    $json['status'] = 400;
    $json['error'] = $error;
    $json['data'] = array();
} else if (count($cards) > 0) {
    $json['status'] = 200;
    $json['error'] = null;
    $json['data'] = $cards;
} else if (count($cards) === 0) {
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
