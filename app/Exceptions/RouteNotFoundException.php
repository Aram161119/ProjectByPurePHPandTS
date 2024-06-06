<?php
namespace App\Exceptions;

use Exception;
use JetBrains\PhpStorm\Pure;
use Throwable;

class RouteNotFoundException extends Exception
{
    #[Pure] public function __construct($message = "Route not found", $code = 404, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
