
<?php

include_once APP_PATH . 'controllers/customer.php';

class TestCustomer extends Test
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

        $customers = getCustomers($search, $sort, $offset, $per_page);

        // Tests if the items are not empty
        $this->assertType($customers, 'array');
        $this->assertEqual(count($customers), $per_page, "Number of items is not equal to per_page.");
        $this->assertArrayNotEmpty($customers);
    }
}
