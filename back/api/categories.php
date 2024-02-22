
<?php

include_once "../config.inc.php";
include_once APP_PATH . '/models/category.php';
include_once APP_PATH . '/models/image.php';

$slug = isset($_GET['slug']) ? $_GET['slug'] : '';
$search = isset($_GET['search']) ? $_GET['search'] : '';
$sort = isset($_GET['sort']) ? $_GET['sort'] : array(array('order' => 'ASC', 'order_by' => 'sort_order'), array('order' => 'ASC', 'order_by' => 'libelle'));
$offset = isset($_GET['offset']) ? $_GET['offset'] : null;
$is_highlander = isset($_GET['is_highlander']) ? $_GET['is_highlander'] : false;
$is_quick_access = isset($_GET['is_quick_access']) ? $_GET['is_quick_access'] : false;
$exclude = isset($_GET['exclude']) ? $_GET['exclude'] : array();
$include = isset($_GET['include']) ? $_GET['include'] : array();
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$per_page = isset($_GET['per_page']) ? $_GET['per_page'] : 10;

if ($exclude) $exclude = explode(',', $exclude[0]);
if ($include) $include = explode(',', $include[0]);

$categories_count = getCategoriesCount($search, $is_highlander, $is_quick_access, $exclude, $include);

$offset = ($page - 1) * $per_page;
$total = ceil($categories_count / $per_page);

$json = array();
$categories = getCategories($search, $is_highlander, $is_quick_access, $exclude, $include, $sort, $offset, $per_page);

if (count($categories) > 0) {
    $json['status'] = 200;
    $json['error'] = null;
    foreach ($categories as &$category) {
        $category['image'] = getImage($category['image_slug']);
    }
    $json['pagination'] = array(
        'page' => intval($page),
        'per_page' => intval($per_page),
        'total' => intval($total),
    );
    $json['data'] = $categories;
} else if (count($categories) === 0) {
    $json['status'] = 400;
    $json['error'] = 'No element found';
    $json['data'] = array();
} else {
    $json['status'] = 500;
    $json['error'] = 'Error while getting getting elements';
}

// Return  JSON
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-type: application/json; charset=utf-8");

$json = json_encode($json);
echo $json;
