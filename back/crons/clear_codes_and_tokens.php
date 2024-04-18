<?php

include_once "../../config.inc.php";
include_once APP_PATH . 'controllers/customer.php';

echo "Clearing codes and tokens...\n";
try {
    clearCodesAndTokens($customer['customer_id']);
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    exit;
} finally {
    echo "Codes and tokens from all users habe been cleaned with success!";
}
echo "<br><br>";
