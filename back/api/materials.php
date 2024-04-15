
<?php

include_once "../config.inc.php";
include_once APP_PATH . '/models/material.php';

$search = isset($_GET['search']) ? $_GET['search'] : '';
$sort = isset($_GET['sort']) ? $_GET['sort'] : array(array('order' => 'ASC', 'order_by' => 'libelle'));
$per_page = isset($_GET['per_page']) ? $_GET['per_page'] : 10;
$page = isset($_GET['page']) ? $_GET['page'] : 1;

$materials_count = getMaterialsCount($search);

$offset = ($page - 1) * $per_page;
$total = ceil($materials_count / $per_page);

$json = array();
$materials = getMaterials($search, $sort, $offset, $per_page);

if (count($materials) > 0) {
    $json['status'] = 200;
    $json['error'] = null;
    $json['data'] = $materials;
} else if (count($materials) === 0) {
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
