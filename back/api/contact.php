<?php

include_once "../config.inc.php";
include_once('../models/contact.php');

$error = null;
$contact = array();

// Vérifie si la méthode de requête est POST ou OPTIONS
if ($_SERVER['REQUEST_METHOD'] === 'POST' || $_SERVER['REQUEST_METHOD'] === 'OPTIONS') {

    // Si la méthode est OPTIONS, renvoie les en-têtes CORS nécessaires
    if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: POST, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type, Authorization");
        exit();
    }

    // Vérifie si les données POST sont vides
    $postData = file_get_contents("php://input");
    if (!$postData) {
        $error = "No data received";
    } else {
        // Traite les données POST en fonction du type de contenu
        $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';
        if ($contentType === "application/x-www-form-urlencoded") {
            parse_str($postData, $_POST);
        } elseif ($contentType === "application/json") {
            $_POST = json_decode($postData, true);
        }

        // Vérifie si les paramètres sont valides
        if (!isset($_POST['customer_id']) || !$_POST['customer_id']) $error = "Missing customer_id";
        else $contact["customer_id"] = htmlspecialchars(strip_tags($_POST['customer_id']));

        if (!isset($_POST['email']) || !$_POST['email']) $error = "Missing email";
        else $contact["email"] = htmlspecialchars(strip_tags($_POST['email']));

        if (!isset($_POST['subject']) || !$_POST['subject']) $error = "Missing subject";
        else $contact["subject"] = htmlspecialchars(strip_tags($_POST['subject']));

        if (!isset($_POST['message']) || !$_POST['message']) $error = "Missing message";
        else $contact["message"] = htmlspecialchars(strip_tags($_POST['message']));
    }
} else {
    $error = "Request method not allowed";
}

// Vérifie si customer_id est valide
if (!$error) {
    // $cust_id = getCustomer($contact["customer_id"]);
    // if (!$cust_id) $error = "Invalid customer_id";
}

// Envoie le contact à la base de données
if (!$error) {
    $error = insertContact($contact);
}

// Prépare et envoie la réponse
$response = array();
$response['status'] = $error ? 'error' : 'success';
$response['message'] = $error ? $error : 'Demande de contact envoyée !';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json");

$response = json_encode($response);
echo $response;
