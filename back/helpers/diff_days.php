<?php

function diff_days($date1, $date2) {
    $date1 = new DateTime($date1);
    $date2 = new DateTime($date2);
    
    $difference = $date1->diff($date2);
    
    return $difference->days;
}