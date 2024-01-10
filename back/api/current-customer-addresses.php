<?php

$addresses = array();

// ...

// Return  JSON
header("Content-type: application/json; charset=utf-8");
$addresses = json_encode($addresses);
echo $addresses;
