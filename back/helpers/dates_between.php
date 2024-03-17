<?php

function dates_between($dateDebut, $dateFin)
{
    $dateDebutObj = new DateTime($dateDebut);
    $dateFinObj = new DateTime($dateFin);
    $dateFinObj->modify('+1 day');

    $interval = new DateInterval('P1D');
    $dateRange = new DatePeriod($dateDebutObj, $interval, $dateFinObj);

    $datesArray = [];

    foreach ($dateRange as $date) {
        $datesArray[] = $date->format('Y-m-d');
    }

    return $datesArray;
}
