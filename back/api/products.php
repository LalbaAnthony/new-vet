
<?php

// ? exemple d'url: http://localhost/projects/new-vet/back/api/products.php?order_by=slug&order=ASC&search=sac

include_once "../config.inc.php";
include_once APP_PATH . '/models/product.php';
include_once APP_PATH . '/models/image.php';
include_once APP_PATH . '/models/category.php';
include_once APP_PATH . '/models/material.php';

$slug = isset($_GET['slug']) ? $_GET['slug'] : '';
$categories = isset($_GET['categories']) ? $_GET['categories'] : array();
$material = isset($_GET['material']) ? $_GET['material'] : array();
$search = isset($_GET['search']) ? $_GET['search'] : '';
$order_by = isset($_GET['order_by']) ? $_GET['order_by'] : 'sort_order';
$order = isset($_GET['order']) ? $_GET['order'] : 'DESC';
$offset = isset($_GET['offset']) ? $_GET['offset'] : null;
$per_page = isset($_GET['per_page']) ? $_GET['per_page'] : 10;
$is_highlander = isset($_GET['is_highlander']) ? $_GET['is_highlander'] : false;
$exclude = isset($_GET['exclude']) ? $_GET['exclude'] : array();

$products = array();

if ($slug) { // Si on a un slug, on recupere un produit
    $product = getProduct($slug);
    if ($product) {
        array_push($products, $product);
    }
} else { // Sinon on recupere tous les produits, selon les parametres
    $products = getProducts($categories, $material, $search, $order_by, $order, $offset, $per_page, $is_highlander, $exclude);
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
