<?php

include_once "../../config.inc.php";
include_once APP_PATH . '/models/customer.php';
include_once APP_PATH . '/helpers/token_gen.php';

$POST_data = json_decode(file_get_contents("php://input"), true);

$error = null;
$json = array();

$email = null;
$old_password = null;
$new_password = null;
$token = null;

$customer = array();

// check if request method is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') $error = "Request method not allowed";

// check if params are valid, 
if (!$error) {
    if (!isset($POST_data['email']) || !$POST_data['email']) $error = "Missing email";
    else $email = strip_tags($POST_data['email']);

    if (!isset($POST_data['old_password']) || !$POST_data['old_password']) $error = "Missing old password";
    else $old_password = $POST_data['old_password'];

    if (!isset($POST_data['new_password']) || !$POST_data['new_password']) $error = "Missing new password";
    else $new_password = $POST_data['new_password'];

    if (!isset($POST_data['token']) || !$POST_data['token']) $error = "Missing token";
    else $token = $POST_data['token'];
}

// Check if user exists
if (!$error) {
    $customer = getCustomerByEmail($email);
    if (!$customer) {
        $error = "Utilisateur introuvable";
    }
}

// Check token
if (!$error) {
    if ($customer && !$customer['connection_token'] === $token) {
        $error = "Token invalide";
    }
}

// change password
if (!$error) {
    if (password_verify($old_password, $customer['password'])) {
        changePassword($customer['customer_id'], password_hash($new_password, PASSWORD_DEFAULT));
    } else {
        $error = "Mot de passe actuel incorrect";
    }
}

// send contact to db
if (!$error) {
    $json['message'] = 'Votre mot de passe a été changé avec succès !';
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
