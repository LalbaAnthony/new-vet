<?php

function fr_datetime($inputDate) {
    $dateTime = new DateTime($inputDate);
    $formattedDate = $dateTime->format('d/m/Y à H:i');

    return $formattedDate;
}