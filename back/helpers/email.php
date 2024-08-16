<?php

function email($to, $subject, $message, $headers = ''): bool
{
    if (empty($to) || empty($subject) || empty($message)) {
        return false;
    }

    if (!filter_var($to, FILTER_VALIDATE_EMAIL)) {
        return false;
    }

    if (!$headers || empty($headers)) {
        $headers = 'From: ' . EMAIL_FROM . "\r\n" .
            'Reply-To: ' . EMAIL_FROM . "\r\n" .
            'X-Mailer: PHP/' . phpversion();
    }

    if (defined('EMAIL_FAKE') && EMAIL_FAKE) {
        $file = APP_PATH . 'emails/last_email.txt';
        $fileopen = (fopen($file, 'a'));

        if (fwrite($fileopen, $to . "\n" . $subject . "\n" . $message . "\n" . $headers . "\n\n")) {
            fclose($fileopen);
            return true;
        }

        fclose($fileopen);
        return false;
    } else {
        if (mail($to, $subject, $message, $headers)) {
            return true;
        }
        return false;
    }
}
