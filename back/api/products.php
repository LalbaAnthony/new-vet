
<?php

// ? exemple d'url: http://localhost/projects/new-vet/back/api/products.php?order_by=slug&order=ASC&search=sac

require_once "../config.inc.php";

$slug = isset($_GET['slug']) ? $_GET['slug'] : '';
$category = isset($_GET['category']) ? $_GET['category'] : array();
$material = isset($_GET['material']) ? $_GET['material'] : array();
$search = isset($_GET['search']) ? $_GET['search'] : '';
$order_by = isset($_GET['order_by']) ? $_GET['order_by'] : 'created_at';
$order = isset($_GET['order']) ? $_GET['order'] : 'DESC';
$offset = isset($_GET['offset']) ? $_GET['offset'] : null;
$per_page = isset($_GET['per_page']) ? $_GET['per_page'] : 10;
$is_highlander = isset($_GET['is_highlander']) ? $_GET['is_highlander'] : false;

$products = array();

if ($slug) { // Si on a un slug, on recupere un produit
    $product = getProduct($slug);
    if ($product) {
        array_push($products, $product);
    }
} else { // Sinon on recupere tous les produits, selon les parametres
    $products = getProducts($category, $material, $search, $order_by, $order, $offset, $per_page, $is_highlander);
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
header("Content-type: application/json; charset=utf-8");
$products = json_encode($products);
echo $products;
