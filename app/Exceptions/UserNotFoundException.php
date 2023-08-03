<?php

namespace App\Exceptions;

use Exception;

class UserNotFoundException extends AbstractException
{
    public function getStatusCode(): int
    {
        return 401;
    }

    public function getStatusMessage(): string
    {
        return 'Incorrect email or password';
    }
}
