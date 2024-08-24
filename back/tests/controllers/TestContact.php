
<?php

include_once APP_PATH . 'models/contact.php';

class TestContact extends Test
{
    public function getItems()
    {
        // Get items
        $search = null;
        $order_by = 'created_at';
        $order = 'ASC';
        $page = 1;

        $sort = array(array('order' => $order, 'order_by' => $order_by));

        $per_page = 2;
        $offset = ($page - 1) * $per_page;

        $contacts = getContacts($search, $sort, $offset, $per_page);

        // Tests if the items are not empty
        $this->assertType($contacts, 'array');
        $this->assertEqual(count($contacts), $per_page, "Number of items is not equal to per_page.");
        $this->assertArrayNotEmpty($contacts);
    }
}
