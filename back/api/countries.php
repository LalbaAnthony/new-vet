
<?php

// ? exemple d'url: http://localhost/projects/new-vet/back/api/countries.php?order=DESC

include_once "../config.inc.php";
include_once('../models/country.php');

$order_by = isset($_GET['order_by']) ? $_GET['order_by'] : 'name';
$order = isset($_GET['order']) ? $_GET['order'] : 'ASC';

$countries = getCountries($order_by, $order);

// Return  JSON
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-type: application/json; charset=utf-8");

$countries = json_encode($countries);
echo $countries;
