<?php

include_once "../config.inc.php";
include_once('../models/contact.php');

$error = null;
$contact = array();

// check if request method is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') $error = "Request method not allowed";

print_r($_POST);

// check if params are valid, 
if (!$error) {
  if (!isset($_POST['customer_id']) || !$_POST['customer_id']) $error = "Missing customer_id";
  else $contact["customer_id"] = htmlspecialchars(strip_tags($_POST['customer_id']));

  if (!isset($_POST['email']) || !$_POST['email']) $error = "Missing email";
  else $contact["email"] = htmlspecialchars(strip_tags($_POST['email']));

  if (!isset($_POST['subject']) || !$_POST['subject']) $error = "Missing subject";
  else $contact["subject"] = htmlspecialchars(strip_tags($_POST['subject']));

  if (!isset($_POST['message']) || !$_POST['message']) $error = "Missing message";
  else $contact["message"] = htmlspecialchars(strip_tags($_POST['message']));
}

// check if customer_id is valid
if (!$error) {
  // $cust_id = getCustomer($contact["customer_id"]);
  // if (!$cust_id) $error = "Invalid customer_id";
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
header("Content-Type: application/x-www-form-urlencoded");

$response = json_encode($response);
echo $response;
