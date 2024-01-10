
<?php

// ? exemple d'url: http://localhost/projects/new-vet/back/api/products.php?order_by=slug&order=ASC&search=sac

require_once "../config.inc.php";

$slug = isset($_GET['slug']) ? $_GET['slug'] : '';
$category = isset($_GET['category']) ? $_GET['category'] : '';
$material = isset($_GET['material']) ? $_GET['material'] : '';
$search = isset($_GET['search']) ? $_GET['search'] : '';
$order_by = isset($_GET['order_by']) ? $_GET['order_by'] : 'created_at';
$order = isset($_GET['order']) ? $_GET['order'] : 'DESC';
$offset = isset($_GET['offset']) ? $_GET['offset'] : null;
$per_page = isset($_GET['per_page']) ? $_GET['per_page'] : 10;

$products = array();

if ($slug) { // Si on a un slug, on recupere un produit
    $product = getProduct($slug);
    if ($product) {
        array_push($products, $product);
    }
} else { // Sinon on recupere tous les produits, selon les parametres
    $products = getProducts($category, $material, $search, $order_by, $order, $offset, $per_page);
}

// Si il y a des produits, on recupere les images et la categorie associée
if (count($products) > 0) {
    foreach ($products as &$product) {
        $product['images'] = getImages($product['slug']);
        $product['category'] = getCategoriesFromProduct($product['slug']);
        $product['material'] = getMaterialsFromProduct($product['slug']);
    }
}

// Return  JSON
header("Content-type: application/json; charset=utf-8");
$products = json_encode($products);
echo $products;
