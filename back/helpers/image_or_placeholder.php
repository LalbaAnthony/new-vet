<?php

function image_or_placeholder($img_path, $full_placeholder_path = 'assets/img/default-img.webp')
{
    $full_img_path = UPLOAD_PATH . $img_path;
    $full_img_url = UPLOAD_URL . $img_path;

    if ($img_path && file_exists($full_img_path)) {
        return $full_img_url;
    } else {
        return APP_URL . $full_placeholder_path;
    }
}
