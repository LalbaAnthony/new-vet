<?php

include_once "../config.inc.php";
include_once APP_PATH . '/models/material.php';

$slug = isset($_GET['slug']) ? $_GET['slug'] : '';

$json = array();

if ($slug) {
    $material = getMaterial($slug);

    if ($material) {
        $json['status'] = 200;
        $json['error'] = null;
        $json['data'] = $material;
    } else {
        $json['status'] = 400;
        $json['error'] = 'No element found';
        $json['data'] = array();
    }
} else {
    $json['status'] = 400;
    $json['error'] = 'No slug provided';
}

// Return  JSON
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-type: application/json; charset=utf-8");

$json = json_encode($json);
echo $json;
