
<?php

include_once "../config.inc.php";
include_once APP_PATH . '/models/product.php';
include_once APP_PATH . '/models/image.php';
include_once APP_PATH . '/models/category.php';
include_once APP_PATH . '/models/material.php';

$slug = isset($_GET['slug']) ? $_GET['slug'] : '';

$json = array();

if ($slug) {
    $product = getProduct($slug);

    if ($product) {
        $product['images'] = getImagesFromProduct($slug);
        $product['categories'] = getCategoriesFromProduct($slug);
        $product['materials'] = getMaterialsFromProduct($slug);

        $json['status'] = 200;
        $json['error'] = null;
        $json['data'] = array($product);
    } else {
        $json['status'] = 400;
        $json['error'] = 'No product found';
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
