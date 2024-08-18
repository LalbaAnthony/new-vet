<?php

require_once "../../config.inc.php";
include_once APP_PATH . 'controllers/card.php';
include_once APP_PATH . 'controllers/customer.php';

$POST_data = json_decode(file_get_contents("php://input"), true);

$error = null;
$json = array();

$token = null;
$customer_id = null;
$card_id = null;

// check if request method is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') $error = "Request method not allowed";

// check if params are valid
if (!$error) {
    if (!isset($POST_data['token']) || !$POST_data['token']) $error = "Missing token";
    else $token = $POST_data['token'];

    if (!isset($POST_data['customer_id']) || !$POST_data['customer_id']) $error = "Missing customer_id";
    else $customer_id = $POST_data['customer_id'];

    if (!isset($POST_data['card_id']) || !$POST_data['card_id']) $error = "Missing card_id";
    else $card_id = $POST_data['card_id'];
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

// check if card exists
if (!$error) {
    $card = getCard($card_id);
    if (!$card) {
        $error = "Carte introuvable";
    }
}

// delete card
if (!$error) {
    $delete = putToTrashCard($card_id);
    if (!$delete) {
        $error = "Erreur lors de la suppression de la carte";
    }
}

// send contact to db
if (!$error) {
    $json['message'] = 'La carte a été supprimée';
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
