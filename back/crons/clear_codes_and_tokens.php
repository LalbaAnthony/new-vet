<?php

require_once "../config.inc.php";
include_once APP_PATH . 'controllers/customer.php';

echo "Clearing codes and tokens...<br>";
try {
    $customers = getCustomers();
    foreach ($customers as $customer) {
        clearCodesAndTokens($customer['customer_id']);
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "<br>";
    die();
} finally {
    echo "Codes and tokens from all users have been cleaned with success!";
}
echo "<br><br>";
