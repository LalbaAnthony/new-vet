
<?php

include_once APP_PATH . 'models/admin.php';

class TestAdmin extends Test
{
    public function getItems()
    {
        // Get items
        $admins = getAdmins();

        // Tests if the items are not empty
        $this->assertType($admins, 'array');
        $this->assertArrayNotEmpty($admins);
    }
}
