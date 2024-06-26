<?php

namespace App\Exceptions;

use Exception;
use Throwable;

class UnauthorizedException extends Exception
{
    /**
     * @param $message
     * @param $code
     * @param Throwable|null $previous
     */
    public function __construct($message = "Unauthorized", $code = 401, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
