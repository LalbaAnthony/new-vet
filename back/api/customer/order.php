<?php

require_once "../../config.inc.php";
include_once APP_PATH . 'controllers/order.php';
include_once APP_PATH . 'controllers/status.php';
include_once APP_PATH . 'controllers/card.php';
include_once APP_PATH . 'controllers/address.php';
include_once APP_PATH . 'controllers/customer.php';
include_once APP_PATH . 'helpers/token_gen.php';

$customer_id = isset($_GET['customer_id']) ? $_GET['customer_id'] : '';
$token = isset($_GET['token']) ? $_GET['token'] : '';
$order_id = isset($_GET['order_id']) ? $_GET['order_id'] : '';

$error = null;
$json = array();
$customer = array();
$order = array();

// check if param is set
if (!$customer_id) $error = "Missing customer_id";
if (!$token) $error = "Missing token";
if (!$order_id) $error = "Missing order_id";

// Get user
if (!$error) {
    $customer = getCustomer($customer_id);
}

// Check if customer_id exists
if (!$error && !$customer) $error = "Aucun utilisateur trouvé";

// Check if token is correct
if (!$error && $token !== $customer["connection_token"]) $error = "Invalid token";

if (!$error)  $order = getOrder($order_id);

// Check if customer_id in order
if (!$error && $order['customer_id'] !== intval($customer_id)) $error = "This order does not belong to this customer";

if (!$error) {
    $order['order_lines'] = getOrderLines($order['order_id']);
    $order['status'] = getStatus($order['status_id']);
    $order['card'] = getCard($order['card_id']);
    $order['shipping_address'] = getAddress($order['shipping_address_id']);
    $order['billing_address'] = getAddress($order['billing_address_id']);
}

if (!$error) {
    if ($order) {
        $json['status'] = 200;
        $json['error'] = null;
        $json['data'] = array($order);
    } else {
        $json['status'] = 400;
        $json['error'] = 'No order found';
    }
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
