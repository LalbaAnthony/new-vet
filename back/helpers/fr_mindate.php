<?php

function fr_mindate($inputDate)
{
    $dateTime = new DateTime($inputDate);
    $formattedDate = $dateTime->format('d/m');

    return $formattedDate;
}
