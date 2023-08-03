<?php

namespace App\Exceptions;

use Exception;

class InternalErrorException extends AbstractException
{

    public function getStatusCode(): int
    {
        return 500;
    }

    public function getStatusMessage(): string
    {
        return 'Internal server error';
    }
}
