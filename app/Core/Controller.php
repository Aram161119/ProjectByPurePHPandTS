<?php

namespace App\Core;

class Controller
{
    /**
     * @param array $data
     * @param string $message
     * @param int $code
     * @return false|string
     */
    protected function successResponse(array $data = [], string $message = 'Operation Successful', int $code = 200): bool|string
    {
        header('Content-Type: application/json');
        http_response_code($code);

        return json_encode([
            'status' => 'success',
            'message' => $message,
            'data' => $data
        ]);
    }

    /**
     * @param array $data
     * @param string $message
     * @param int $code
     * @return false|string
     */
    protected function errorResponse(array $data = [], string $message = 'Operation is failed', int $code = 400): bool|string
    {
        header('Content-Type: application/json');
        http_response_code($code);

        return json_encode([
            'status' => 'error',
            'message' => $message,
            'data' => $data
        ]);
    }
}
