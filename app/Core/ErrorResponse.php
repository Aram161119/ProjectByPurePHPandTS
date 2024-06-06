<?php

namespace App\Core;

use App\Exceptions\UnauthorizedException;
use App\Exceptions\RouteNotFoundException;
use Throwable;

class ErrorResponse
{
    /**
     * @param Throwable $exception
     * @return void
     */
    public static function handle(Throwable $exception): void
    {
        if ($exception instanceof UnauthorizedException) {
            http_response_code(401);
            echo $exception->getMessage();
        } elseif ($exception instanceof RouteNotFoundException) {
            http_response_code(404);
            echo $exception->getMessage();
        } else {
            http_response_code(500);
            echo 'Internal Server Error';
        }
    }
}
