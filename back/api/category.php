<?php

include_once "../config.inc.php";
include_once APP_PATH . '/models/category.php';
include_once APP_PATH . '/models/image.php';

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

$json = array();

if ($slug) {
    $category = getCategory($slug);

    if ($category) {
        $json['status'] = 200;
        $json['error'] = null;
        $category['image'] = getImage($category['image_slug']);
        $json['data'] = $category;
    } else {
        $json['status'] = 400;
        $json['error'] = 'No element found';
        $json['data'] = array();
    }
} else {
    $json['status'] = 400;
    $json['error'] = 'No slug provided';
}


// Return  JSON
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-type: application/json; charset=utf-8");

$json = json_encode($json);
echo $json;
