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

    if (strlen($message) > 500) {
        $errors[] = "Message can not be more than 500 characters.";
    }

    return $errors;
}
