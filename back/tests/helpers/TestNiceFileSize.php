<?php

include_once APP_PATH . 'helpers/nice_file_size.php';

class TestNiceFileSize extends Test
{
    public function main()
    {
        $size = 1234567890;
        $nice_size = nice_file_size($size);
        $this->assertTrue($nice_size == '1.15 Go');
    }
}