<?php

namespace App\Exceptions;

class IncorrectDataException extends AbstractException
{

    public function getStatusCode(): int
    {
        return 422;
    }

    public function getStatusMessage(): string
    {
        return 'Incorrect data';
    }
}
