
<?php

include_once APP_PATH . 'controllers/order.php';

class TestOrder extends Test
{
    public function getItems()
    {
        // Get items
        $order_by = 'created_at';
        $order = 'ASC';
        $sort = array(array('order' => $order, 'order_by' => $order_by));
        $page = 1;
        $per_page = 10;

        $offset = ($page - 1) * $per_page;

        $orders = getOrders(null, null, null, null, $sort, $offset, $per_page, null);

        // Tests if the items are not empty
        $this->assertType($orders, 'array');
        $this->assertEqual(count($orders), $per_page, 'Number of items is not equal to per_page.');
        $this->assertArrayNotEmpty($orders);
    }
}
