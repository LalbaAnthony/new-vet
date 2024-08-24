<?php

require_once "../../config.inc.php";
include_once APP_PATH . 'models/card.php';
include_once APP_PATH . 'models/customer.php';

$POST_data = json_decode(file_get_contents("php://input"), true);

$error = null;
$json = array();

$token = null;
$customer_id = null;

$first_name = null;
$last_name = null;
$number = null;
$expiration_date = null;
$cvv = null;

// check if request method is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') $error = "Request method not allowed";

// check if params are valid
if (!$error) {
    if (!isset($POST_data['token']) || !$POST_data['token']) $error = "Missing token";
    else $token = $POST_data['token'];

    if (!isset($POST_data['customer_id']) || !$POST_data['customer_id']) $error = "Missing customer_id";
    else $customer_id = $POST_data['customer_id'];

    if (!isset($POST_data['first_name']) || !$POST_data['first_name']) $error = "Missing first_name";
    else $first_name = $POST_data['first_name'];

    if (!isset($POST_data['last_name']) || !$POST_data['last_name']) $error = "Missing last_name";
    else $last_name = $POST_data['last_name'];

    if (!isset($POST_data['number']) || !$POST_data['number']) $error = "Missing number";
    else $number = $POST_data['number'];

    if (!isset($POST_data['expiration_date']) || !$POST_data['expiration_date']) $error = "Missing expiration_date";
    else $expiration_date = $POST_data['expiration_date'];

    if (!isset($POST_data['cvv']) || !$POST_data['cvv']) $error = "Missing cvv";
    else $cvv = $POST_data['cvv'];
}

// Check if user exists
if (!$error) {
    $customer = getCustomer($customer_id);
    if (!$customer) {
        $error = "Utilisateur introuvable";
    }
}

// Check code
if (!$error) {
    if ($token !== $customer['connection_token']) {
        $error = "Token invalide";
    }
}

// add card
if (!$error) {
    $card = array(
        'first_name' => $first_name,
        'last_name' => $last_name,
        'number' => $number,
        'expiration_date' => $expiration_date,
        'cvv' => $cvv,
        'customer_id' => $customer_id
    );

    $card_id = insertCard($card);
}

// send contact to db
if (!$error) {
    $json['message'] = 'La carte a été ajoutée avec succès';
    $json['status'] = 200;
    $json['error'] = null;
} else {
    $json['status'] = 400;
    $json['error'] = $error;
}

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header("Content-type: application/json; charset=utf-8");

$json = json_encode($json);
echo $json;
