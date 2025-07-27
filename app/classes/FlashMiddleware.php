<?php

namespace App;

/**
 * Set flash message as a global variable on the Flight instance.
 */
class FlashMiddleware
{
    public function before(): void
    {
        \Flight::set('flash', getFlash());
    }
}
