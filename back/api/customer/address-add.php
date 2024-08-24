<?php

require_once "../../config.inc.php";
include_once APP_PATH . 'models/address.php';
include_once APP_PATH . 'models/customer.php';

$POST_data = json_decode(file_get_contents("php://input"), true);

$error = null;
$json = array();

$token = null;
$customer_id = null;

$first_name = null;
$last_name = null;
$address1 = null;
$address2 = null;
$city = null;
$region = null;
$zip = null;
$country_id = null;
$tel = null;

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

    if (!isset($POST_data['address1']) || !$POST_data['address1']) $error = "Missing address1";
    else $address1 = $POST_data['address1'];
    
    if (!isset($POST_data['address2']) || !$POST_data['address2']) $error = "Missing address2";
    else $address2 = $POST_data['address2'];

    if (!isset($POST_data['city']) || !$POST_data['city']) $error = "Missing city";
    else $city = $POST_data['city'];

    if (!isset($POST_data['region']) || !$POST_data['region']) $error = "Missing region";
    else $region = $POST_data['region'];

    if (!isset($POST_data['zip']) || !$POST_data['zip']) $error = "Missing zip";
    else $zip = $POST_data['zip'];

    if (!isset($POST_data['country_id']) || !$POST_data['country_id']) $error = "Missing country_id";
    else $country_id = (int) $POST_data['country_id'];

    if (!isset($POST_data['tel']) || !$POST_data['tel']) $error = "Missing tel";
    else $tel = $POST_data['tel'];
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

// add address
if (!$error) {
    $address = array(
        'customer_id' => $customer_id,
        'first_name' => $first_name,
        'last_name' => $last_name,
        'address1' => $address1,
        'address2' => $address2,
        'city' => $city,
        'region' => $region,
        'zip' => $zip,
        'country_id' => $country_id,
        'tel' => $tel
    );

    $address_id = insertAddress($address);
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
