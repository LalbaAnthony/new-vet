
<?php

require_once "../config.inc.php";
log_txt("Access to products.php");

$slug = isset($_GET['slug']) ? $_GET['slug'] : '';
$category = isset($_GET['category']) ? $_GET['category'] : '';

$products = array();

if ($slug) {
    $product = getProduct($slug);
    if ($product) {
        array_push($products, $product);
    }
} elseif ($category) {
    $product = getProducts($category);
} else {
    $products = getProducts();
}

foreach ($products as $product) {
    // ..
}
// Return  JSON
header("Content-type: application/json; charset=utf-8");
$products = json_encode($products);
echo $products;
