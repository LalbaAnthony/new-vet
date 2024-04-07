<?php

function email($to, $subject, $message)
{
    $headers = 'From: ' . EMAIL_FROM . "\r\n" .
        'Reply-To: ' . EMAIL_FROM . "\r\n" .
        'X-Mailer: PHP/' . phpversion();
    mail($to, $subject, $message, $headers);
}