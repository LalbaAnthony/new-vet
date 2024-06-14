<?php

function slugify($txt)
{
    if (empty($txt)) return '';
    $slug = $txt;
    $slug = strtolower($slug);
    $slug = str_replace(' ', '-', $slug);
    $slug = preg_replace('/[^A-Za-z0-9\-]/', '', $slug);
    return $slug;
}
