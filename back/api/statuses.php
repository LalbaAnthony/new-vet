
<?php

require_once "../config.inc.php";
include_once APP_PATH . 'models/status.php';

$json = array();
$statuses = getStatuses();

if (count($statuses) > 0) {
  $json['status'] = 200;
  $json['error'] = null;
  $json['data'] = $statuses;
} else if (count($statuses) === 0) {
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
