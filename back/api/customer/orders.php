<?php

require_once "../../config.inc.php";
include_once APP_PATH . 'controllers/order.php';
include_once APP_PATH . 'controllers/status.php';
include_once APP_PATH . 'controllers/card.php';
include_once APP_PATH . 'controllers/country.php';
include_once APP_PATH . 'controllers/address.php';
include_once APP_PATH . 'controllers/customer.php';
include_once APP_PATH . 'helpers/token_gen.php';
include_once APP_PATH . 'controllers/product.php';

$customer_id = isset($_GET['customer_id']) ? $_GET['customer_id'] : '';
$token = isset($_GET['token']) ? $_GET['token'] : '';
$date_start = isset($_GET['date_start']) ? $_GET['date_start'] : null;
$date_end = isset($_GET['date_end']) ? $_GET['date_end'] : null;
$search = isset($_GET['search']) ? $_GET['search'] : '';
$sort = isset($_GET['sort']) ? $_GET['sort'] : array(array('order' => 'DESC', 'order_by' => 'order_date'));
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$per_page = isset($_GET['per_page']) ? $_GET['per_page'] : 10;
$include_status = array();
$include_status_string = isset($_GET['include_status']) ? $_GET['include_status'] : null;

if ($include_status_string) {
    $include_status = explode(',', $include_status_string);
    foreach ($include_status as &$status) {
        $status = intval($status);
    }
}

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

    $orders_count = getOrdersCount($date_start, $date_end, $search, $customer_id, $include_status);

    $offset = ($page - 1) * $per_page;
    $total = ceil($orders_count / $per_page);

    $orders = getOrders($date_start, $date_end, $search, $customer_id, $sort, $offset, $per_page, $include_status);

    $json['pagination'] = array(
        'page' => intval($page),
        'per_page' => intval($per_page),
        'total' => intval($total),
    );

    if (count($orders) > 0) {
        $json['status'] = 200;
        $json['error'] = null;
        foreach ($orders as &$order) {
            $order['order_lines'] = getOrderLines($order['order_id']);
            $order['status'] = getStatus($order['status_id']);
            $order['card'] = getCard($order['card_id']);

            foreach ($order['order_lines'] as &$order_line) {
                $order_line['product'] = getProduct($order_line['product_slug']);
            }

            $order['shipping_address'] = getAddress($order['shipping_address_id']);
            if ($order['shipping_address']['country_id']) $order['shipping_address']['country'] = getCountry($order['shipping_address']['country_id']);
            else $order['shipping_address']['country'] = null;

            $order['billing_address'] = getAddress($order['billing_address_id']);
            if ($order['billing_address']['country_id']) $order['billing_address']['country'] = getCountry($order['billing_address']['country_id']);
            else $order['shipping_address']['country'] = null;
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
