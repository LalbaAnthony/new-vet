<?php

include_once APP_PATH . 'helpers/diff_days.php';

class TestDiffDays extends Test
{
    public function main()
    {
        $date1 = '2020-01-01';
        $date2 = '2020-01-10';
        $diff = diff_days($date1, $date2);
        $this->assertTrue($diff == 9);
    }
}