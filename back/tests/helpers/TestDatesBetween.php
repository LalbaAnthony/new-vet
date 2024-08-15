<?php

include_once APP_PATH . 'helpers/dates_between.php';

class TestDatesBetween extends Test
{
    public function main()
    {
        $date1 = '2020-01-01';
        $date2 = '2020-01-10';
        $dates = dates_between($date1, $date2);
        $this->assertTrue(is_array($dates));
        $this->assertTrue(count($dates) == 10);
        $this->assertTrue($dates[0] == '2020-01-01');
        $this->assertTrue($dates[9] == '2020-01-10');
    }
}
