<?php


function three_dots_string(string $txt, int $max = 100)
{
    if (strlen($txt) > $max) return substr($txt, 0, $max) . ' ...';
    return $txt;
}