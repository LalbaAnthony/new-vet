
<?php

include_once APP_PATH . 'models/product.php';

class TestProduct extends Test
{
    public function getItems()
    {
        // Get items
        $search = '';
        $sort = array(array('order' => 'ASC', 'order_by' => 'sort_order'), array('order' => 'DESC', 'order_by' => 'stock_quantity'));
        $is_highlander = false;
        $page = 1;
        $per_page = 10;
        
        $categories = array();
        $materials = array();
        $exclude = array();
        $include = array();
        
        $offset = ($page - 1) * $per_page;
        
        $products = getProducts($categories, $materials, $search, $is_highlander, $exclude, $include, $sort, $offset, $per_page);

        // Tests if the items are not empty
        $this->assertType($products, 'array');
        $this->assertEqual(count($products), $per_page, 'Number of items is not equal to per_page.');
        $this->assertArrayNotEmpty($products);
    }
}
