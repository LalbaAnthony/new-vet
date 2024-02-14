
<?php

include_once "../config.inc.php";
include_once APP_PATH . '/models/product.php';
include_once APP_PATH . '/models/image.php';
include_once APP_PATH . '/models/category.php';
include_once APP_PATH . '/models/material.php';

$categories = isset($_GET['categories']) ? $_GET['categories'] : array();
$materials = isset($_GET['materials']) ? $_GET['materials'] : array();
$search = isset($_GET['search']) ? $_GET['search'] : '';
$sort = isset($_GET['sort']) ? $_GET['sort'] : array(array('order' => 'ASC', 'order_by' => 'sort_order'), array('order' => 'DESC', 'order_by' => 'stock_quantity'));
$offset = isset($_GET['offset']) ? $_GET['offset'] : null;
$is_highlander = isset($_GET['is_highlander']) ? $_GET['is_highlander'] : false;
$exclude = isset($_GET['exclude']) ? $_GET['exclude'] : array();
$include = isset($_GET['include']) ? $_GET['include'] : array();
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$per_page = isset($_GET['per_page']) ? $_GET['per_page'] : 10;

if ($categories) $categories = explode(',', $categories[0]);
if ($materials) $materials = explode(',', $materials[0]);
if ($exclude) $exclude = explode(',', $exclude[0]);
if ($include) $include = explode(',', $include[0]);

$products_count = getProductsCount($categories, $materials, $search, $is_highlander, $exclude, $include);

$offset = ($page - 1) * $per_page;
$total = ceil($products_count / $per_page);

$json = array();
$products = getProducts($categories, $materials, $search, $is_highlander, $exclude, $include, $sort, $offset, $per_page);

if (count($products) > 0) {
    $json['status'] = 200;
    $json['error'] = null;
    foreach ($products as &$product) {
        $product['images'] = getImagesFromProduct($product['slug']);
        $product['categories'] = getCategoriesFromProduct($product['slug']);
        $product['materials'] = getMaterialsFromProduct($product['slug']);
    }
    $json['pagination'] = array(
        'page' => intval($page),
        'per_page' => intval($per_page),
        'total' => intval($total),
    );
    $json['data'] = $products;
} else if (count($products) === 0) {
    $json['status'] = 400;
    $json['error'] = 'No element found';
    $json['data'] = array();
} else {
    $json['status'] = 500;
    $json['error'] = 'Error while getting getting elements';
}

// Return  JSON
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-type: application/json; charset=utf-8");

$json = json_encode($json);
echo $json;
