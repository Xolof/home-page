<?php

/**
 * Get an array with errors from the form data.
 */
function getFormErrors(string $name, string $email, string $message): array
{
    $errors = [];

    if ($name === '') {
        $errors[] = "Name can not be empty.";
    }

    if ($email === '') {
        $errors[] = "Email can not be empty.";
    }

    if ($message === '') {
        $errors[] = "Message can not be empty.";
    }

    if (strlen($name) > 50) {
        $errors[] = "Name can not be more than 50 characters.";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Email must be a valid email address.";
    }

    if (strlen($message) > 1000) {
        $errors[] = "Message can not be more than 1000 characters.";
    }

    return $errors;
}

/**
 * Set a flash message.
 */
function setFlash(string $message, string $type): void
{
    $_SESSION["flash"] = [
        "message" => $message,
        "type"    => $type
    ];
}

/**
 * Get a flash message.
 */
function getFlash(): array
{
    $result = [];

    if (isset($_SESSION["flash"])) {
        $message = $_SESSION["flash"]["message"];
        $type = $_SESSION["flash"]["type"];

        $result = [
            "message" => $message,
            "type"    => $type
        ];
    }

    unset($_SESSION["flash"]);

    return $result;
}

/**
 * Start up the session.
 */
function startSession(string $domain): void
{
    session_set_cookie_params([
        'lifetime' => 0,
        'path' => '/',
        'domain' => $domain ?? 'localhost',
        'secure' => true,
        'httponly' => true,
        'samesite' => 'Strict'
    ]);

    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }
}
