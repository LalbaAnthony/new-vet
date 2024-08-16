<?php

function dd(mixed $var)
{
    $args = func_get_args();

    echo "<pre>";
    foreach ($args as $arg) {
        var_dump($arg);
    }
    echo "</pre>";
}
