<?php

include_once "../config.inc.php";
include_once APP_PATH . '/models/contact.php';
include_once APP_PATH . '/models/customer.php';

$POST_data = json_decode(file_get_contents("php://input"), true);

$error = null;
$contact = array();

// check if request method is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') $error = "Request method not allowed";

// check if params are valid, 
if (!$error) {

  if (!isset($POST_data['email']) || !$POST_data['email']) $error = "Missing email";
  else $contact["email"] = htmlspecialchars(strip_tags($POST_data['email']));

  if (!isset($POST_data['subject']) || !$POST_data['subject']) $error = "Missing subject";
  else $contact["subject"] = htmlspecialchars(strip_tags($POST_data['subject']));

  if (!isset($POST_data['message']) || !$POST_data['message']) $error = "Missing message";
  else $contact["message"] = htmlspecialchars(strip_tags($POST_data['message']));
}

// check if customer_id is valid
if (!$error) {
  if (isset($POST_data['customer_id']) && $POST_data['customer_id'] !== "null") {
    $cust_id = intval(htmlspecialchars(strip_tags($POST_data['customer_id'])));
    if (getCustomer($cust_id) === false) {
      $error = "Invalid customer_id";
    } else {
      $contact["customer_id"] = $cust_id;
    }
  }
}

// send contact to db
if (!$error) {
  $error = insertContact($contact);
}

$response = array();
$response['status'] = $error ? 'error' : 'success';
$response['message'] = $error ? $error : 'Demande de contact envoyée !';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header("Content-type: application/json; charset=utf-8");

$response = json_encode($response);
echo $response;
