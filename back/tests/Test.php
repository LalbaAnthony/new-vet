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

    public function setTestName(string $testName): void
    {
        $this->testName = $testName;
    }

    public function getTestName(): string
    {
        return $this->testName;
    }

    public function assertArrayNotEmpty(array $actualArray): bool
    {
        if ($actualArray && count($actualArray) > 0) {
            $this->passed++;
            return true;
        } else {
            $this->failed++;
            array_push($this->errors, "Test failed. Array is empty.");
            return false;
        }
    }

    public function assertEqual(mixed $actual, mixed $expected): bool
    {
        if ($expected === $actual) {
            $this->passed++;
            return true;
        } else {
            $this->failed++;
            array_push($this->errors, "Test failed. Expected: $expected, Got: $actual");
            return false;
        }
    }

    public function assertType(mixed $actualData, string $expectedType): bool
    {

        $popssiblesTypes = ['integer', 'double', 'string', 'array', 'object', 'boolean', 'NULL', 'resource', 'unknown type'];

        if (!in_array($expectedType, $popssiblesTypes)) {
            $this->failed++;
            array_push($this->errors, "Test failed. Invalid type.");
            return false;
        }

        if ($expectedType == gettype($actualData)) {
            $this->passed++;
            return true;
        } else {
            $this->failed++;
            array_push($this->errors, "Test failed. Expected type: $expectedType, Got type: " . gettype($actualData));
            return false;
        }
    }

    public function assertTrue(bool $condition): bool
    {
        if ($condition) {
            $this->passed++;
            return true;
        } else {
            $this->failed++;
            array_push($this->errors, "Test failed. Condition is false.");
            return false;
        }
    }

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
