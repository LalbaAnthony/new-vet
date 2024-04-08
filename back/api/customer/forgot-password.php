<?php

include_once APP_PATH . '/helpers/code_gen.php';

$json = array();

// ...

// Return  JSON
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-type: application/json; charset=utf-8");

$json = json_encode($json);
echo $json;
