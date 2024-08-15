<?php

include_once APP_PATH . 'helpers/float_to_price.php';

class TestFloatToPrice extends Test
{
    public function main()
    {
        $float = 1234567890;
        $price = float_to_price($float);
        $this->assertTrue($price == '1 234 567 890,00&nbsp;€');
    }
}