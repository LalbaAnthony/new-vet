<?php

$cards = array();

// ...

// Return  JSON
header("Content-type: application/json; charset=utf-8");
$cards = json_encode($cards);
echo $cards;
