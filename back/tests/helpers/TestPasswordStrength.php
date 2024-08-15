<?php

include_once APP_PATH . 'helpers/password_strength.php';

class TestPasswordStrength extends Test
{
    public function main()
    {
        $password = 'pwd';
        $score = password_strength($password);
        $this->assertTrue($score == 1);

        $password = 'password';
        $score = password_strength($password);
        $this->assertTrue($score == 2);

        $password = 'Password';
        $score = password_strength($password);
        $this->assertTrue($score == 3);

        $password = 'Password1';
        $score = password_strength($password);
        $this->assertTrue($score == 4);

        $password = 'Password1!';
        $score = password_strength($password);
        $this->assertTrue($score == 5);
    }
}