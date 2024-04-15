<?php

function dd($var)
{
    $args = func_get_args();

    echo "<pre>";
    foreach ($args as $arg) {
        var_dump($arg);
    }
    echo "</pre>";
}
