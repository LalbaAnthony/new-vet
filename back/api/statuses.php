
<?php

// ? exemple d'url: http://localhost/projects/new-vet/back/api/statuses.php

include_once "../config.inc.php";
include_once APP_PATH . '/models/status.php';

$order_by = isset($_GET['order_by']) ? $_GET['order_by'] : 'created_at';
$order = isset($_GET['order']) ? $_GET['order'] : 'DESC';

$statuses = getStatuses($order_by, $order);

// Return  JSON
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-type: application/json; charset=utf-8");

$statuses = json_encode($statuses);
echo $statuses;
