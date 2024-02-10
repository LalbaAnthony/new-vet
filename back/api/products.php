
<?php

include_once "../config.inc.php";
include_once APP_PATH . '/models/product.php';
include_once APP_PATH . '/models/image.php';
include_once APP_PATH . '/models/category.php';
include_once APP_PATH . '/models/material.php';

$slug = isset($_GET['slug']) ? $_GET['slug'] : '';
$categories = isset($_GET['categories']) ? $_GET['categories'] : array();
$material = isset($_GET['material']) ? $_GET['material'] : array();
$search = isset($_GET['search']) ? $_GET['search'] : '';
$sort = isset($_GET['sort']) ? $_GET['sort'] : array(array('order' => 'ASC', 'order_by' => 'sort_order'), array('order' => 'DESC', 'order_by' => 'stock_quantity'));
$offset = isset($_GET['offset']) ? $_GET['offset'] : null;
$per_page = isset($_GET['per_page']) ? $_GET['per_page'] : 10;
$is_highlander = isset($_GET['is_highlander']) ? $_GET['is_highlander'] : false;
$exclude = isset($_GET['exclude']) ? $_GET['exclude'] : array();
$include = isset($_GET['include']) ? $_GET['include'] : array();

if ($categories) $categories = explode(',', $categories[0]);
if ($material) $material = explode(',', $material[0]);
if ($exclude) $exclude = explode(',', $exclude[0]);
if ($include) $include = explode(',', $include[0]);

$products = array();

if ($slug) { // Si on a un slug, on recupere un produit
    $product = getProduct($slug);
    if ($product) {
        array_push($products, $product);
    }
} else { // Sinon on recupere tous les produits, selon les parametres
    $products = getProducts($categories, $material, $search, $sort, $offset, $per_page, $is_highlander, $exclude, $include);
}

// Si il y a des produits, on recupere les images et la categorie associée
if (count($products) > 0) {
    foreach ($products as &$product) {
        $product['images'] = getImagesFromProduct($product['slug']);
        $product['categories'] = getCategoriesFromProduct($product['slug']);
        $product['materials'] = getMaterialsFromProduct($product['slug']);
    }
}

// Return  JSON
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-type: application/json; charset=utf-8");

$products = json_encode($products);
echo $products;
