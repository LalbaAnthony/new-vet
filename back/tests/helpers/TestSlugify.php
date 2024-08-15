<?php

include_once APP_PATH . 'helpers/slugify.php';

class TestSlugify extends Test
{
    public function main()
    {
        $string = 'Hello, World!';
        $slug = slugify($string);
        $this->assertTrue($slug == 'hello-world');
    }
}