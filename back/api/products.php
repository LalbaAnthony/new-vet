
<?php

require_once "../config.inc.php";
include_once APP_PATH . 'controllers/product.php';
include_once APP_PATH . 'controllers/image.php';
include_once APP_PATH . 'controllers/category.php';
include_once APP_PATH . 'controllers/material.php';

$categories_string = isset($_GET['categories'][0]) ? $_GET['categories'][0] : array();
$materials_string = isset($_GET['materials'][0]) ? $_GET['materials'][0] : array();
$exclude_string = isset($_GET['exclude'][0]) ? $_GET['exclude'][0] : array();
$include_string = isset($_GET['include'][0]) ? $_GET['include'][0] : array();
$search = isset($_GET['search']) ? $_GET['search'] : '';
$sort = isset($_GET['sort']) ? $_GET['sort'] : array(array('order' => 'ASC', 'order_by' => 'sort_order'), array('order' => 'DESC', 'order_by' => 'stock_quantity'));
$is_highlander = isset($_GET['is_highlander']) ? $_GET['is_highlander'] : false;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$per_page = isset($_GET['per_page']) ? $_GET['per_page'] : 10;

$categories = array();
$materials = array();
$exclude = array();
$include = array();
if ($categories_string && strlen($categories_string)) $categories = explode(',', $categories_string);
if ($materials_string && strlen($materials_string)) $materials = explode(',', $materials_string);
if ($exclude_string && strlen($exclude_string)) $exclude = explode(',', $exclude_string);
if ($include_string && strlen($include_string)) $include = explode(',', $include_string);

$products_count = getProductsCount($categories, $materials, $search, $is_highlander, $exclude, $include);

$offset = ($page - 1) * $per_page;
$total = ceil($products_count / $per_page);

$json = array();
$products = getProducts($categories, $materials, $search, $is_highlander, $exclude, $include, $sort, $offset, $per_page);

$json['pagination'] = array(
    'page' => intval($page),
    'per_page' => intval($per_page),
    'total' => intval($total),
);
if (count($products) > 0) {
    $json['status'] = 200;
    $json['error'] = null;
    foreach ($products as &$product) {
        $product['images'] = getImagesFromProduct($product['slug']);
        $product['categories'] = getCategoriesFromProduct($product['slug']);
        $product['materials'] = getMaterialsFromProduct($product['slug']);
    }
    $json['data'] = $products;
} else if (count($products) === 0) {
    $json['status'] = 400;
    $json['error'] = 'No element found';
    $json['data'] = array();
} else {
    $json['status'] = 500;
    $json['error'] = 'Error while getting elements';
}

// Return  JSON
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-type: application/json; charset=utf-8");

$json = json_encode($json);
echo $json;
