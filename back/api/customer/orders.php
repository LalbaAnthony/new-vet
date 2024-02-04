<?php

$orders = array();

// ...

// Return  JSON
header("Content-type: application/json; charset=utf-8");
$orders = json_encode($orders);
echo $orders;
