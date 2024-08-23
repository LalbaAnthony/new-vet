<?php

function token_gen($length = 32)
{
    $length = $length / 2; // Because we are using bin2hex
    return bin2hex(random_bytes($length));
}
