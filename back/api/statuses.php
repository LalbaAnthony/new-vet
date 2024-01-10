
<?php

// ? exemple d'url: http://localhost/projects/new-vet/back/api/statuses.php

require_once "../config.inc.php";

$order_by = isset($_GET['order_by']) ? $_GET['order_by'] : 'created_at';
$order = isset($_GET['order']) ? $_GET['order'] : 'DESC';

$statuses = getStatuses($order_by, $order);

// Return  JSON
header("Content-type: application/json; charset=utf-8");
$statuses = json_encode($statuses);
echo $statuses;
