
<?php

include_once APP_PATH . 'controllers/category.php';

class TestCategories extends Test
{
    public function doesTableHaveLines()
    {
        // Get categories
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

        // Tests
        $this->assertArrayNotEmpty($categories);
    }
}
