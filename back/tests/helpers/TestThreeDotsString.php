<?php

include_once APP_PATH . 'helpers/three_dots_string.php';

class TestThreeDotsString extends Test
{
    public function main()
    {
        $txt = '1234567890';
        $max = 5;
        $three_dots_txt = three_dots_string($txt, $max);
        $this->assertTrue($three_dots_txt == '12345 ...');
    }
}