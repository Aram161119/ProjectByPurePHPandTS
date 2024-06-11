<?php
namespace App\Exceptions;

use Exception;
use Throwable;

class RouteNotFoundException extends Exception
{
    public function __construct($message = "Route not found", $code = 404, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
