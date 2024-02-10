
<?php

include_once "../config.inc.php";
include_once APP_PATH . '/models/material.php';

$slug = isset($_GET['slug']) ? $_GET['slug'] : '';
$search = isset($_GET['search']) ? $_GET['search'] : '';
$sort = isset($_GET['sort']) ? $_GET['sort'] : array(array('order' => 'ASC', 'order_by' => 'libelle'));
$offset = isset($_GET['offset']) ? $_GET['offset'] : null;
$per_page = isset($_GET['per_page']) ? $_GET['per_page'] : 10;

$materials = array();

if ($slug) { // Si on a un slug, on recupere un produit
    $category = getCategory($slug);
    if ($category) {
        array_push($materials, $category);
    }
} else { // Sinon on recupere tous les produits, selon les parametres
    $materials = getMaterials($search, $sort, $offset, $per_page);
}

// Return  JSON
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-type: application/json; charset=utf-8");

$materials = json_encode($materials);
echo $materials;
