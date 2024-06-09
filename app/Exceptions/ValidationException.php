<?php

namespace App\Exceptions;

use Exception;
use Throwable;

class ValidationException extends Exception
{
    /**
     * @param $message
     * @param $code
     * @param Throwable|null $previous
     */
    public function __construct($message = "Validation is not passed", $code = 422, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
