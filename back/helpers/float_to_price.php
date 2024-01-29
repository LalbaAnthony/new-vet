<?php

function float_to_price($float) {
    $price = number_format($float, 2, ',', ' ') . ' €';

    return $price;
}