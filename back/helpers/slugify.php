<?php

function slugify($txt)
{
    $slug = $txt;
    $slug = strtolower($slug);
    $slug = str_replace(' ', '-', $slug);
    $slug = preg_replace('/[^A-Za-z0-9\-]/', '', $slug);
    return $slug;
}
