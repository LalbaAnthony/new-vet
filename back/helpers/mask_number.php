<?php
function mask_number($number)
{
    $strNumber = (string)$number;

    $length = strlen($strNumber);

    if ($length <= 4) {
        return $strNumber;
    }

    $maskedStr = str_repeat('*', $length - 4) . substr($strNumber, -4);

    return $maskedStr;
}
