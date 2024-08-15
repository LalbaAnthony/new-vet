<?php

// ? Go to http://localhost/projects/new-vet/back/tests/index.php if run in XAMPP environment

require_once "../config.inc.php";

include_once APP_PATH . 'tests/Test.php';

include_once APP_PATH . 'tests/controllers/TestCategories.php';

include_once APP_PATH . 'tests/helpers/TestDatesBetween.php';
include_once APP_PATH . 'tests/helpers/TestDiffDays.php';
include_once APP_PATH . 'tests/helpers/TestFloatToPrice.php';
include_once APP_PATH . 'tests/helpers/TestFrDate.php';
include_once APP_PATH . 'tests/helpers/TestFrDatetime.php';
include_once APP_PATH . 'tests/helpers/TestFrMindate.php';
include_once APP_PATH . 'tests/helpers/TestImageOrPlaceholder.php';
include_once APP_PATH . 'tests/helpers/TestMaskNumber.php';
include_once APP_PATH . 'tests/helpers/TestNiceFileSize.php';
include_once APP_PATH . 'tests/helpers/TestPasswordStrength.php';
include_once APP_PATH . 'tests/helpers/TestRandColor.php';
include_once APP_PATH . 'tests/helpers/TestSlugify.php';
include_once APP_PATH . 'tests/helpers/TestThreeDotsString.php';
include_once APP_PATH . 'tests/helpers/TestTokenGen.php';

echo "<pre>";

// CONTROLLERS

$test = new TestCategories('TestCategories');
$test->doesTableHaveLines();
$test->printReport();

// HERLPERS

$test = new TestDatesBetween('TestDatesBetween');
$test->main();
$test->printReport();

$test = new TestDiffDays('TestDiffDays');
$test->main();
$test->printReport();

$test = new TestFloatToPrice('TestFloatToPrice');
$test->main();
$test->printReport();

$test = new TestFrDate('TestFrDate');
$test->main();
$test->printReport();

$test = new TestFrDatetime('TestFrDatetime');
$test->main();
$test->printReport();

$test = new TestFrMindate('TestFrMindate');
$test->main();
$test->printReport();

$test = new TestImageOrPlaceholder('TestImageOrPlaceholder');
$test->main();
$test->printReport();

$test = new TestMaskNumber('TestMaskNumber');
$test->main();
$test->printReport();

$test = new TestNiceFileSize('TestNiceFileSize');
$test->main();
$test->printReport();

$test = new TestPasswordStrength('TestPasswordStrength');
$test->main();
$test->printReport();

$test = new TestRandColor('TestRandColor');
$test->main();
$test->printReport();

$test = new TestSlugify('TestSlugify');
$test->main();
$test->printReport();

$test = new TestThreeDotsString('TestThreeDotsString');
$test->main();
$test->printReport();

$test = new TestTokenGen('TestTokenGen');
$test->main();
$test->printReport();

echo "</pre>";
