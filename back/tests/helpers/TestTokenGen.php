<?php

include_once APP_PATH . 'helpers/token_gen.php';

class TestTokenGen extends Test
{
    public function main()
    {
        $length = 32;
        $token = token_gen($length);
        $this->assertTrue(strlen($token) == 64);
        $this->assertType($token, 'string');
    }
}