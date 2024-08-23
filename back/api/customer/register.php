<?php

require_once "../../config.inc.php";
include_once APP_PATH . 'controllers/customer.php';
include_once APP_PATH . 'helpers/token_gen.php';
include_once APP_PATH . 'helpers/email.php';

$POST_data = json_decode(file_get_contents("php://input"), true);

$error = null;
$json = array();
$customer = array();

// check if request method is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') $error = "Request method not allowed";

// check if param is set
if (!$error && !isset($POST_data['customer']) || !$POST_data['customer']) $error = "Missing customer data";

// check if params are valid, 
if (!$error) {
    if (!isset($POST_data['customer']['first_name']) || !$POST_data['customer']['first_name']) $error = "Missing name";
    else $customer["first_name"] = strip_tags($POST_data['customer']['first_name']);

    if (!isset($POST_data['customer']['last_name']) || !$POST_data['customer']['last_name']) $error = "Missing message";
    else $customer["last_name"] = strip_tags($POST_data['customer']['last_name']);

    if (!isset($POST_data['customer']['email']) || !$POST_data['customer']['email']) $error = "Missing email";
    else $customer["email"] = strip_tags($POST_data['customer']['email']);

    if (!isset($POST_data['customer']['password']) || !$POST_data['customer']['password']) $error = "Missing password";
    else $customer["password"] = strip_tags($POST_data['customer']['password']);
}

// Check if email already exists
if (!$error) {
    $existing_customer = getCustomerByEmail($customer["email"]);
    if ($existing_customer) {
        $error = "Un utilisateur avec cet email existe déjà";
    }
}

// insert customer
if (!$error) {
    $customer["password"] = password_hash($customer["password"], PASSWORD_DEFAULT);
    $customer["has_validated_email"] = 0;

    $sucess = insertCustomer($customer);
    $error = $sucess ? null : "Error while inserting contact";

    $token = setHasValidateEmailTokenByEmail($customer["email"]);
    $subject = "Validation de votre email";
    $message = "Bonjour,<br><br>Veuillez cliquer sur le lien suivant pour valider votre email : <a href='" . FRONT_URL . "?email=" . $customer["email"] . "&token=" . $token . "'>Valider mon email</a><br><br>Cordialement,<br>L'équipe " . COMPANY_NAME;
    email($customer["email"], $subject, $message);
}

// send contact to db
if (!$error) {
    $json['message'] = 'Vous vous êtes inscrit avec succès !';
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
