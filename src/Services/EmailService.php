<?php

namespace App\Services;

class EmailService
{
    public function send(string $email, string $message): void
    {
        echo "Sending email to $email: $message\n";
    }
}
