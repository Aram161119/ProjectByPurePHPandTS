<?php

namespace App\Requests;

use App\Core\Request;

class LoginRequest extends Request
{
    /**
     * @return string[]
     */
    public function rules(): array
    {
        return [
            'email' => 'required|email',
            'password' => 'required|min:6|max:255',
        ];
    }
}