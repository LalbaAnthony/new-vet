<?php

include_once "../config.inc.php";
include_once APP_PATH . '/models/contact.php';
include_once APP_PATH . '/models/customer.php';

$POST_data = json_decode(file_get_contents("php://input"), true);

$error = null;
$json = array();
$contact = array();

// check if request method is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') $error = "Request method not allowed";

// check if params are valid, 
if (!$error) {

  if (!isset($POST_data['email']) || !$POST_data['email']) $error = "Missing email";
  else $contact["email"] = strip_tags($POST_data['email']);

  if (!isset($POST_data['subject']) || !$POST_data['subject']) $error = "Missing subject";
  else $contact["subject"] = strip_tags($POST_data['subject']);

  if (!isset($POST_data['message']) || !$POST_data['message']) $error = "Missing message";
  else $contact["message"] = strip_tags($POST_data['message']);
}

// check if customer_id is valid
if (!$error) {
  if (isset($POST_data['customer_id']) && $POST_data['customer_id'] !== "null") {
    $cust_id = intval(strip_tags($POST_data['customer_id']));
    if (getCustomer($cust_id) === false) {
      $error = "Invalid customer_id";
    } else {
      $contact["customer_id"] = $cust_id;
    }
  }
}

if (!$error) {
  $error = insertContact($contact);
}

// send contact to db
if (!$error) {
  $json['message'] = 'Demande de contact envoyée !';
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
