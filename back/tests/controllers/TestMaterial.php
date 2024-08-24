
<?php

include_once APP_PATH . 'models/material.php';

class TestMaterial extends Test
{
    public function getItems()
    {
        // Get items
        $search = '';
        $sort = array(array('order' => 'ASC', 'order_by' => 'libelle'));
        $per_page = 10;
        $page = 1;

        $offset = ($page - 1) * $per_page;

        $materials = getMaterials($search, $sort, $offset, $per_page);

        // Tests if the items are not empty
        $this->assertType($materials, 'array');
        $this->assertEqual(count($materials), $per_page, 'Number of items is not equal to per_page.');
        $this->assertArrayNotEmpty($materials);
    }
}
