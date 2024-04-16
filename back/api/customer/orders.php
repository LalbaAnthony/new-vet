<?php

include_once "../../config.inc.php";
include_once APP_PATH . '/models/order.php';
include_once APP_PATH . '/models/status.php';
include_once APP_PATH . '/models/card.php';
include_once APP_PATH . '/models/address.php';
include_once APP_PATH . '/models/customer.php';
include_once APP_PATH . '/helpers/token_gen.php';

$customer_id = isset($_GET['customer_id']) ? $_GET['customer_id'] : '';
$token = isset($_GET['token']) ? $_GET['token'] : '';
$date_start = isset($_GET['date_start']) ? $_GET['date_start'] : null;
$date_end = isset($_GET['date_end']) ? $_GET['date_end'] : null;
$search = isset($_GET['search']) ? $_GET['search'] : '';
$sort = isset($_GET['sort']) ? $_GET['sort'] : array(array('order' => 'DESC', 'order_by' => 'order_date'));
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$per_page = isset($_GET['per_page']) ? $_GET['per_page'] : 10;

$error = null;
$json = array();
$customer = array();
$orders = array();

// check if param is set
if (!$customer_id) $error = "Missing customer_id";
if (!$token) $error = "Missing token";

// Get user
if (!$error) {
    $customer = getCustomer($customer_id);
}

// Check if customer_id exists
if (!$error && !$customer) $error = "Aucun utilisateur trouvé";

// Check if token is correct
if (!$error && $token !== $customer["connection_token"]) $error = "Invalid token";

if (!$error) {

    $orders_count = getOrdersCount($date_start, $date_end, $search, $customer_id);

    $offset = ($page - 1) * $per_page;
    $total = ceil($orders_count / $per_page);

    $orders = getOrders($date_start, $date_end, $search, $customer_id, $sort, $offset, $per_page);

    $json['pagination'] = array(
        'page' => intval($page),
        'per_page' => intval($per_page),
        'total' => intval($total),
    );

    if (count($orders) > 0) {
        $json['status'] = 200;
        $json['error'] = null;
        foreach ($orders as &$order) {
            // $order['order_lines'] = getOrderLines($order['order_id']);
            $order['status'] = getStatus($order['status_id']);
            // $order['card'] = getCard($order['card_id']);
            // $order['shipping_address'] = getAddress($order['shipping_address_id']);
            // $order['billing_address'] = getAddress($order['billing_address_id']);
        }
        $json['data'] = $orders;
    } else if (count($orders) === 0) {
        $json['status'] = 400;
        $json['error'] = 'No element found';
        $json['data'] = array();
    } else {
        $json['status'] = 500;
        $json['error'] = 'Error while getting elements';
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
