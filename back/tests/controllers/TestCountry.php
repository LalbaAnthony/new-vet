
<?php

include_once APP_PATH . 'models/country.php';

class TestCountry extends Test
{
    public function getItems()
    {
        // Get items
        $countries = getCountries();

        // Tests if the items are not empty
        $this->assertType($countries, 'array');
        $this->assertArrayNotEmpty($countries);
    }
}
