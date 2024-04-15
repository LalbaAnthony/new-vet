<?php

include_once "../config.inc.php";
include_once APP_PATH . '/controllers/category.php';
include_once APP_PATH . '/controllers/image.php';

$slug = isset($_GET['slug']) ? $_GET['slug'] : '';

$json = array();

if ($slug) {
    $category = getCategory($slug);

    if ($category) {
        $json['status'] = 200;
        $json['error'] = null;
        $category['image'] = getImage($category['image_slug']);
        $json['data'] = array($category);
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
