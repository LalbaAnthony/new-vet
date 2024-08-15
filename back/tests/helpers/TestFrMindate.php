<?php

include_once APP_PATH . 'helpers/fr_date.php';

class TestFrMindate extends Test
{
    public function main()
    {
        $date = '2020-01-01';
        $fr_date = fr_date($date);
        $this->assertTrue($fr_date == '01/01/2020');
    }
}