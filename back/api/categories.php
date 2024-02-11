
<?php

include_once "../config.inc.php";
include_once APP_PATH . '/models/category.php';

$slug = isset($_GET['slug']) ? $_GET['slug'] : '';
$search = isset($_GET['search']) ? $_GET['search'] : '';
$sort = isset($_GET['sort']) ? $_GET['sort'] : array(array('order' => 'ASC', 'order_by' => 'sort_order'), array('order' => 'ASC', 'order_by' => 'libelle'));
$offset = isset($_GET['offset']) ? $_GET['offset'] : null;
$per_page = isset($_GET['per_page']) ? $_GET['per_page'] : 10;
$is_highlander = isset($_GET['is_highlander']) ? $_GET['is_highlander'] : false;
$is_quick_access = isset($_GET['is_quick_access']) ? $_GET['is_quick_access'] : false;
$exclude = isset($_GET['exclude']) ? $_GET['exclude'] : array();
$include = isset($_GET['include']) ? $_GET['include'] : array();

if ($exclude) $exclude = explode(',', $exclude[0]);
if ($include) $include = explode(',', $include[0]);

$categories = array();

if ($slug) { // Si on a un slug, on recupere un produit
    $category = getCategory($slug);
    if ($category) {
        array_push($categories, $category);
    }
} else if ($is_quick_access) { // Si on veut celle en accès rapide
    $categories = getCategoriesQuickAccess();
} else { // Sinon on recupere tous les produits, selon les parametres
    $categories = getCategories($search, $sort, $offset, $per_page, $is_highlander, $exclude, $include);
}

// Return  JSON
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-type: application/json; charset=utf-8");

$categories = json_encode($categories);
echo $categories;
