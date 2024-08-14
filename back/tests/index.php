<?php

// ? Go to http://localhost/projects/new-vet/back/tests/index.php if run in XAMPP environment

require_once "../config.inc.php";

include_once APP_PATH . 'tests/Test.php';
include_once APP_PATH . 'tests/controllers/TestCategories.php';
include_once APP_PATH . 'tests/helpers/TestRandColor.php';

echo "<pre>";

$test = new TestCategories('TestCategories');
$test->doesTableHaveLines();
$test->printReport();

$test = new TestRandColor('TestRandColor');
$test->main();
$test->printReport();

echo "</pre>";
