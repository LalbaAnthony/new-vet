
<?php

include_once APP_PATH . 'models/image.php';

class TestImage extends Test
{
    public function getItems()
    {
        // Get items
        $search = null;
        $order_by = 'created_at';
        $order = 'ASC';
        $page = 1;
        $sort = array(array('order' => $order, 'order_by' => $order_by));

        $per_page = 10;
        $offset = ($page - 1) * $per_page;

        $images = getImages($search, $sort, $offset, $per_page);

        // Tests if the items are not empty
        $this->assertType($images, 'array');
        $this->assertEqual(count($images), $per_page, 'Number of items is not equal to per_page.');
        $this->assertArrayNotEmpty($images);
    }
}
