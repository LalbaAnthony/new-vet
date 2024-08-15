
<?php

include_once APP_PATH . 'helpers/rand_color.php';

class TestRandColor extends Test
{
    public function main()
    {
        $color = rand_color();
        $this->assertTrue(is_string($color));
        $this->assertTrue(strlen($color) == 7);
        $this->assertTrue($color[0] == '#');
        $this->assertTrue(ctype_xdigit(substr($color, 1)));
    }
}
