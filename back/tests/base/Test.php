<?php

class Test
{
    private string $testName = '';
    private int $passed = 0;
    private int $failed = 0;
    private array $errors = [];

    function __construct(string $testName = '')
    {
        $this->setTestName($testName);
    }

    /**
     * Set the value of testName
     * 
     * @param string $testName Name of the test
     * @return void 
     */
    public function setTestName(string $testName): void
    {
        $this->testName = $testName;
    }

    /**
     * Get the value of testName
     * 
     * @return string 
     */
    public function getTestName(): string
    {
        return $this->testName;
    }

    /**
     * Check if an array is empty
     * 
     * @param array $actualArray Array to check
     * @param string $message Message to display if the test fails
     * @return int
     * */
    public function assertArrayEmpty(array $actualArray, string $message = 'Test failed.'): bool
    {
        if (!$actualArray || count($actualArray) == 0) {
            $this->passed++;
            return true;
        } else {
            $this->failed++;
            array_push($this->errors, $message . "Array is not empty.");
            return false;
        }
    }


    /**
     * Check if an array is not empty
     * 
     * @param array $actualArray Array to check
     * @param string $message Message to display if the test fails
     * @return int
     * */
    public function assertArrayNotEmpty(array $actualArray, string $message = 'Test failed.'): bool
    {
        if ($actualArray && count($actualArray) > 0) {
            $this->passed++;
            return true;
        } else {
            $this->failed++;
            array_push($this->errors, $message . "Array is empty.");
            return false;
        }
    }

    /**
     * Check if both values are equal
     * 
     * @param mixed $actual Actual value
     * @param mixed $expected Expected value
     * @param string $message Message to display if the test fails
     * */
    public function assertEqual(mixed $actual, mixed $expected, string $message = 'Test failed.'): bool
    {
        if ($expected === $actual) {
            $this->passed++;
            return true;
        } else {
            $this->failed++;
            array_push($this->errors, $message . "Expected: $expected, Got: $actual");
            return false;
        }
    }

    /**
     * Check if both values are not equal
     * 
     * @param mixed $actual Actual value
     * @param mixed $expected Expected value
     * @param string $message Message to display if the test fails
     * */
    public function assertNotEqual(mixed $actual, mixed $expected, string $message = 'Test failed.'): bool
    {
        if ($expected !== $actual) {
            $this->passed++;
            return true;
        } else {
            $this->failed++;
            array_push($this->errors, $message . "Expected not: $expected, Got: $actual");
            return false;
        }
    }

    /**
     * Check if the type of a value is the expected one
     * 
     * @param mixed $actualData Actual value
     * @param string $expectedType Expected type
     * @param string $message Message to display if the test fails
     * */
    public function assertType(mixed $actualData, string $expectedType, string $message = 'Test failed.'): bool
    {

        $popssiblesTypes = ['integer', 'double', 'string', 'array', 'object', 'boolean', 'NULL', 'resource', 'unknown type'];

        if (!in_array($expectedType, $popssiblesTypes)) {
            $this->failed++;
            array_push($this->errors, $message . "Invalid type.");
            return false;
        }

        if ($expectedType == gettype($actualData)) {
            $this->passed++;
            return true;
        } else {
            $this->failed++;
            array_push($this->errors, $message . "Expected type: $expectedType, Got type: " . gettype($actualData));
            return false;
        }
    }

    /**
     * Check if a condition is true
     * 
     * @param bool $condition Condition to check
     * @param string $message Message to display if the test fails
     * */
    public function assertTrue(bool $condition, string $message = 'Test failed.'): bool
    {
        if ($condition) {
            $this->passed++;
            return true;
        } else {
            $this->failed++;
            array_push($this->errors, $message . "Condition is false.");
            return false;
        }
    }

    /**
     * Check if a condition is false
     * 
     * @param bool $condition Condition to check
     * @param string $message Message to display if the test fails
     * */
    public function assertFalse(bool $condition, string $message = 'Test failed.'): bool
    {
        if (!$condition) {
            $this->passed++;
            return true;
        } else {
            $this->failed++;
            array_push($this->errors, $message . "Condition is true.");
            return false;
        }
    }

    /**
     * Check if a value is null
     * 
     * @param mixed $value Value to check
     * @param string $message Message to display if the test fails. Should be put in '<pre/>' tags.
     * */
    public function printReport(): void
    {
        echo "\n\n";
        echo "=====================\n";
        if ($this->getTestName()) {
            echo "Test report for " . $this->getTestName() . "\n";
        } else {
            echo "Test report\n";
        }
        echo "=====================\n";
        echo "\n\n";

        echo "Total tests: " . ($this->passed + $this->failed) . "\n";
        echo $this->passed . " tests passed.\n";
        echo $this->failed . " tests failed.\n";

        if (count($this->errors) > 0) {
            echo "<p style='color: white; background-color: red;'>";
            echo "Some tests failed : \n";
            foreach ($this->errors as $error) {
                echo "- " . $error . "\n";
            }
            echo "</p>";
        } else {
            echo "<p style='color: white; background-color: green;'>";
            echo "All tests passed.\n";
            echo "</p>";
        }
    }
}
