<?php

include_once "../../../config.inc.php";
include_once APP_PATH . "/models/image.php";

$images = getImages();

?>
<script src="<?= APP_URL ?>bo/script/functions/goToConfirm.js"></script>
<div>
    <label>Images:</label>
    <div class="d-flex justify-content-between align-items-center" style="overflow-x: scroll; max-width: 100%;">
        <!-- Images list -->
        <?php foreach ($images as $image) : ?>
            <?php
                $full_img_path = UPLOAD_PATH . $image['path'];
                $full_img_url = UPLOAD_URL . $image['path'];
            ?>
            <?php if (file_exists($full_img_path)) : ?>
                <div class="d-flex flex-column align-items-center">
                    <img src="<?= $full_img_url ?>" class="m-1 object-fit-cover" alt="<?= $image['alt'] ?>" width="100px" height="100px">
                    <input type="checkbox" name="images_slugs[]" value="<?= $image['slug'] ?>" <?php echo (isset($selected_images) && in_array($image['slug'], $selected_images)) ? 'checked' : '' ?>>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>

        <!-- Add button -->
        <div class="mx-4">
            <div class="btn btn-primary rounded-circle w-100 h-100 d-flex justify-content-center align-items-center" onclick="goToConfirm('<?= APP_URL ?>bo/pages/images/create_image.php')">
                <span class="">&#43;</span>
            </div>
        </div>
    </div>
</div>

<script>
    // Allow only three checkbox to be checked
    var checkboxes = document.querySelectorAll('input[type="checkbox"]');
    const max = <?= $max_nb_images ?> || 1;
    for (var i = 0; i < checkboxes.length; i++) {
        checkboxes[i].addEventListener('change', function() {
            var checked = document.querySelectorAll('input[type="checkbox"]:checked');
            if (checked.length > max) {
                alert(`Vous ne pouvez pas sélectionner plus de ${max} images`);
                this.checked = false;
            }
        });
    }
</script>