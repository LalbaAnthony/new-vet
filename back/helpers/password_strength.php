<?php

function password_strength($password)
{
    $score = 0;
    if (strlen($password) >= 8) $score++;
    if (preg_match("/[0-9]/", $password)) $score++;
    if (preg_match("/[a-z]/", $password)) $score++;
    if (preg_match("/[A-Z]/", $password)) $score++;
    if (preg_match("/[^a-zA-Z0-9]/", $password)) $score++;

    return $score;
}
