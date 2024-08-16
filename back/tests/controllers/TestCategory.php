
<?php

include_once APP_PATH . 'controllers/category.php';

class TestCategory extends Test
{
    public function getItems()
    {
        // Get items
        $search =  '';
        $sort =  array(array('order' => 'ASC', 'order_by' => 'sort_order'), array('order' => 'ASC', 'order_by' => 'libelle'));
        $is_highlander =  false;
        $is_quick_access =  false;
        $page =  1;
        $per_page =  10;
        $exclude = array();
        $include = array();

        $offset = ($page - 1) * $per_page;
        $categories = getCategories($search, $is_highlander, $is_quick_access, $exclude, $include, $sort, $offset, $per_page);

        // Tests if the items are not empty
        $this->assertType($categories, 'array');
        $this->assertEqual(count($categories), $per_page, 'Number of items is not equal to per_page.');
        $this->assertArrayNotEmpty($categories);
    }
}
