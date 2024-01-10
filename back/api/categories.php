
<?php

// ? exemple d'url: http://localhost/projects/new-vet/back/api/categories.php

include_once "../config.inc.php";
include_once('../models/category.php');

$slug = isset($_GET['slug']) ? $_GET['slug'] : '';
$search = isset($_GET['search']) ? $_GET['search'] : '';
$order_by = isset($_GET['order_by']) ? $_GET['order_by'] : 'sort_order';
$order = isset($_GET['order']) ? $_GET['order'] : 'ASC';
$offset = isset($_GET['offset']) ? $_GET['offset'] : null;
$per_page = isset($_GET['per_page']) ? $_GET['per_page'] : 10;
$quick_access = isset($_GET['quick_access']) ? $_GET['quick_access'] : false;

$categories = array();

if ($slug) { // Si on a un slug, on recupere un produit
    $category = getCategory($slug);
    if ($category) {
        array_push($categories, $category);
    }
} else if ($quick_access) { // Si on veut celle en accès rapide
    $categories = getCategoriesQuickAcces();
} else { // Sinon on recupere tous les produits, selon les parametres
    $categories = getCategories($search, $order_by, $order, $offset, $per_page);
}

// Return  JSON
header("Content-type: application/json; charset=utf-8");
$categories = json_encode($categories);
echo $categories;
