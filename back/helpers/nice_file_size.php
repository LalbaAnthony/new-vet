<?php

function nice_file_size($size)
{
    $units = array('o', 'Ko', 'Mo', 'Go', 'To');
    for ($i = 0; $size > 1024; $i++) {
        $size /= 1024;
    }
    return round($size, 2) . ' ' . $units[$i];
}
