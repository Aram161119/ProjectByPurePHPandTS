<?php

namespace App\Middleware;

use App\Exceptions\UnauthorizedException;

class AdminMiddleware
{
    /**
     * @throws UnauthorizedException
     */
    public function handle(): void
    {
        if (!isset($_SESSION['admin_email'])) {
            throw new UnauthorizedException('401 - Unauthorized');
        }
    }
}
