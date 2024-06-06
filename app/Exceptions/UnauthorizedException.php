<?php
// UnauthorizedException.php

namespace App\Exceptions;

use Exception;
use JetBrains\PhpStorm\Pure;
use Throwable;

class UnauthorizedException extends Exception
{
    #[Pure] public function __construct($message = "Unauthorized", $code = 401, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
