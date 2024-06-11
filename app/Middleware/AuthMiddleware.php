<?php

namespace App\Middleware;

use App\Exceptions\UnauthorizedException;

class AuthMiddleware
{
    /**
     * @throws UnauthorizedException
     */
    public function handle(): void
    {
        if (!isset($_SESSION['admin'])) {
            throw new UnauthorizedException('401 - Unauthorized');
        }
    }
}
