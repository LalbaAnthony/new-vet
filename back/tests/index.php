<?php

// ? Go to http://localhost/projects/new-vet/back/tests/index.php if run in XAMPP environment

require_once "../config.inc.php";

include_once APP_PATH . 'tests/base/Test.php';

include_once APP_PATH . 'tests/models/TestAddress.php';
include_once APP_PATH . 'tests/models/TestAdmin.php';
include_once APP_PATH . 'tests/models/TestCard.php';
include_once APP_PATH . 'tests/models/TestCategory.php';
include_once APP_PATH . 'tests/models/TestContact.php';
include_once APP_PATH . 'tests/models/TestCountry.php';
include_once APP_PATH . 'tests/models/TestCustomer.php';
include_once APP_PATH . 'tests/models/TestImage.php';
include_once APP_PATH . 'tests/models/TestMaterial.php';
include_once APP_PATH . 'tests/models/TestOrder.php';
include_once APP_PATH . 'tests/models/TestProduct.php';
include_once APP_PATH . 'tests/models/TestStatus.php';

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

include_once APP_PATH . 'tests/utils/TestDatabase.php';

include_once APP_PATH . 'helpers/email.php';
email('test@gmail.com', 'Test', 'Test');

echo "<pre>";

// MODELS

echo "\n\n";
echo "======================================================================================================================================================\n";
echo "MODELS\n";
echo "======================================================================================================================================================\n";

$test = new TestAddress('TestAddress');
$test->getItems();
$test->printReport();

$test = new TestAdmin('TestAdmin');
$test->getItems();
$test->printReport();

$test = new TestCard('TestCard');
$test->getItems();
$test->printReport();

$test = new TestCategory('TestCategory');
$test->getItems();
$test->printReport();

$test = new TestContact('TestContact');
$test->getItems();
$test->printReport();

$test = new TestCountry('TestCountry');
$test->getItems();
$test->printReport();

$test = new TestCustomer('TestCustomer');
$test->getItems();
$test->printReport();

$test = new TestImage('TestImage');
$test->getItems();
$test->printReport();

$test = new TestMaterial('TestMaterial');
$test->getItems();
$test->printReport();

$test = new TestOrder('TestOrder');
$test->getItems();
$test->printReport();

$test = new TestProduct('TestProduct');
$test->getItems();
$test->printReport();

$test = new TestStatus('TestStatus');
$test->getItems();
$test->printReport();

// HELPERS

echo "\n\n";
echo "======================================================================================================================================================\n";
echo "HELPERS\n";
echo "======================================================================================================================================================\n";

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

// UTILS

echo "\n\n";
echo "======================================================================================================================================================\n";
echo "UTILS\n";
echo "======================================================================================================================================================\n";

$test = new TestDatabase('TestDatabase');
$test->doesDatabaseConnect();
$test->printReport();

echo "</pre>";
