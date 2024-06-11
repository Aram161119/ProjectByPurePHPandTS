<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\ErrorResponse;
use App\Exceptions\UnauthorizedException;
use App\Managers\AdminManager;
use App\Requests\LoginRequest;
use App\Exceptions\ValidationException;

class AuthController extends Controller
{
    /**
     * @return bool|string|void
     */
    public function login()
    {
        try {
            $loginRequest = new LoginRequest();

            if (!$loginRequest->validate()) {
                throw new ValidationException();
            }

            $data = $loginRequest->getData();

            $manager = new AdminManager();
            $hashedPassword = $manager->getHashedPassword($data['email']);

            if ($hashedPassword && password_verify($data['password'], $hashedPassword)) {
                $_SESSION['admin'] = $data['email'];
                return $this->successResponse(code: 204);
            }

            throw new UnauthorizedException('Authorization failed');
        } catch (\Throwable $e) {
            return ErrorResponse::handle($e);
        }
    }

    /**
     * @return bool|string
     */
    public function logout(): bool|string
    {
        session_unset();
        session_destroy();
        return $this->successResponse(code: 204);
    }
}
