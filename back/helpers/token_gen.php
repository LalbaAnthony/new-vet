<?php

function token_gen($length = 32)
{
    return bin2hex(random_bytes($length));
}
