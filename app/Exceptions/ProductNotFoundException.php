<?php

namespace App\Exceptions;

class ProductNotFoundException extends AbstractException
{

    public function getStatusCode(): int
    {
        return 404;
    }

    public function getStatusMessage(): string
    {
        return 'Not found';
    }
}
