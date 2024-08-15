<?php

include_once APP_PATH . 'helpers/mask_number.php';

class TestMaskNumber extends Test
{
    public function main()
    {
        $number = 1234567890;
        $masked_number = mask_number($number);
        $this->assertTrue($masked_number == '******7890');
    }
}