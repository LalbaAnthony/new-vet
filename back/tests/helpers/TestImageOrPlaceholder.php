<?php

include_once APP_PATH . 'helpers/image_or_placeholder.php';

class TestImageOrPlaceholder extends Test
{
    public function main()
    {
        $img_path = 'assets/img/default-img.webp';
        $full_placeholder_path = 'assets/img/default-img.webp';
        $full_img_path = APP_UPLOAD_PATH . $img_path;
        $full_img_url = APP_UPLOAD_URL . $img_path;
        $this->assertTrue(image_or_placeholder($img_path, $full_placeholder_path) == APP_URL . $full_placeholder_path);
    }
}