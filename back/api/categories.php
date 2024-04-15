
<?php

include_once "../config.inc.php";
include_once APP_PATH . '/models/category.php';
include_once APP_PATH . '/models/image.php';

$search = isset($_GET['search']) ? $_GET['search'] : '';
$sort = isset($_GET['sort']) ? $_GET['sort'] : array(array('order' => 'ASC', 'order_by' => 'sort_order'), array('order' => 'ASC', 'order_by' => 'libelle'));
$is_highlander = isset($_GET['is_highlander']) ? $_GET['is_highlander'] : false;
$is_quick_access = isset($_GET['is_quick_access']) ? $_GET['is_quick_access'] : false;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$per_page = isset($_GET['per_page']) ? $_GET['per_page'] : 10;
$exclude_string = isset($_GET['exclude'][0]) ? $_GET['exclude'][0] : array();
$include_string = isset($_GET['include'][0]) ? $_GET['include'][0] : array();

$exclude = array();
$include = array();

if ($exclude_string && strlen($exclude_string)) $exclude = explode(',', $exclude_string);
if ($include_string && strlen($include_string)) $include = explode(',', $include_string);

$categories_count = getCategoriesCount($search, $is_highlander, $is_quick_access, $exclude, $include);

$offset = ($page - 1) * $per_page;
$total = ceil($categories_count / $per_page);

$json = array();
$categories = getCategories($search, $is_highlander, $is_quick_access, $exclude, $include, $sort, $offset, $per_page);

$json['pagination'] = array(
    'page' => intval($page),
    'per_page' => intval($per_page),
    'total' => intval($total),
);
if (count($categories) > 0) {
    $json['status'] = 200;
    $json['error'] = null;
    foreach ($categories as &$category) {
        $category['image'] = getImage($category['image_slug']);
    }
    $json['data'] = $categories;
} else if (count($categories) === 0) {
    $json['status'] = 400;
    $json['error'] = 'No element found';
    $json['data'] = array();
} else {
    $json['status'] = 500;
    $json['error'] = 'Error while getting elements';
}

// Return  JSON
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-type: application/json; charset=utf-8");

$json = json_encode($json);
echo $json;
