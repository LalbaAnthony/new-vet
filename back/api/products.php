
<?php

require_once "../config.inc.php";

$slug = isset($_GET['slug']) ? $_GET['slug'] : '';
$category = isset($_GET['category']) ? $_GET['category'] : '';

$products = array();

if ($slug) { // Si on a un slug, on recupere un produit
    $product = getProduct($slug);
    if ($product) {
        array_push($products, $product);
    }
} elseif ($category) { // Si on a une categorie, on recupere les produits de cette categorie
    $products = getProducts($category);
} else { // Sinon on recupere tous les produits
    $products = getProducts();
}

// Si il y a des produits, on recupere les images
if (count($products) > 0) {
    foreach ($products as &$product) {
        $product['images'] = getImages($product['slug']);
        $product['category'] = getCategory($product['category_slug']);
    }
}
// Return  JSON
header("Content-type: application/json; charset=utf-8");
$products = json_encode($products);
echo $products;
