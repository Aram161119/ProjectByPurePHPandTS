<?php

namespace App\Requests;

use App\Core\Request;

class CreateAdminRequest extends Request
{
    /**
     * @return string[]
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|min:2|max:255',
            'email' => 'required|email',
            'password' => 'required|string|min:6|max:255',
        ];
    }
}