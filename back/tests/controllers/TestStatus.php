
<?php

include_once APP_PATH . 'controllers/status.php';

class TestStatus extends Test
{
    public function getItems()
    {
        // Get items
        $statuses = getStatuses();

        // Tests if the items are not empty
        $this->assertType($statuses, 'array');
        $this->assertArrayNotEmpty($statuses);
    }
}
