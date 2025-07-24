<?php

namespace App;

class Mailer
{
    public function send(string $receiver, string $subject, string $message, string $from)
    {
        $headers = [
            'From' => $from,
            'X-Mailer' => 'PHP/' . phpversion(),
            'MIME-Version' => '1.0',
            'Content-Type' => 'text/html; charset=UTF-8'
        ];

        try {
            mail($receiver, $subject, $message, $headers);
            echo "Email sent to $receiver.\n";
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }
}
