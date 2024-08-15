<?php

include_once APP_PATH . 'helpers/fr_datetime.php';

class TestFrDatetime extends Test
{
    public function main()
    {
        $date = '2020-12-31 23:59:59';
        $formatted_date = fr_datetime($date);
        $this->assertTrue($formatted_date == '31/12/2020 à 23:59');
    }
}