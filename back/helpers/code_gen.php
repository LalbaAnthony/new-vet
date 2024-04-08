<?php

function code_gen($length = 6)
{
    $byteLength = ceil($length / 2);
    $randomBytes = random_bytes($byteLength);
    $randomNumber = hexdec(bin2hex($randomBytes));
    $randomNumber = substr($randomNumber, 0, $length);

    return $randomNumber;
}
