<?php

$customer = array();

// ...

// Return  JSON
header("Content-type: application/json; charset=utf-8");
$customer = json_encode($customer);
echo $customer;
