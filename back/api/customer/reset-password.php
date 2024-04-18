<?php

require_once "../../config.inc.php";
include_once APP_PATH . 'controllers/customer.php';
include_once APP_PATH . 'helpers/password_strength.php';

$POST_data = json_decode(file_get_contents("php://input"), true);

$error = null;
$json = array();

$email = null;
$new_password = null;
$code = null;

$customer = array();

// check if request method is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') $error = "Request method not allowed";

// check if params are valid, 
if (!$error) {
    if (!isset($POST_data['email']) || !$POST_data['email']) $error = "Missing email";
    else $email = strip_tags($POST_data['email']);

    if (!isset($POST_data['new_password']) || !$POST_data['new_password']) $error = "Missing new password";
    else $new_password = $POST_data['new_password'];

    if (!isset($POST_data['code']) || !$POST_data['code']) $error = "Missing code";
    else $code = $POST_data['code'];
}

// Check if user exists
if (!$error) {
    $customer = getCustomerByEmail($email);
    if (!$customer) {
        $error = "Utilisateur introuvable";
    }
}

// Check code
if (!$error) {
    if ($customer['reset_password_code'] != $code) {
        $error = "Code invalide";
    }
}

// check if new password has changed
if (!$error) {
    if (password_verify($new_password, $customer['password'])) {
        $error = "Le nouveau mot de passe doit être différent de l'ancien";
    }
}

// check if new password is valid
if (!$error) {
    if (password_strength($new_password) < 4) {
        $error = "Le mot de passe est trop faible";
    }
}

// change password
if (!$error) {
    changePassword($customer['customer_id'], password_hash($new_password, PASSWORD_DEFAULT));
    clearCodesAndTokens($customer['customer_id'], array('reset_password_code'));
}

// send contact to db
if (!$error) {
    $json['message'] = 'Votre mot de passe a été réinitialisé avec succès !';
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
