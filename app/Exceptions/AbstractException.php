<?php

namespace App\Exceptions;

use Exception;

abstract class AbstractException extends Exception
{
    abstract public function getStatusCode(): int;

    abstract public function getStatusMessage(): string;
}
