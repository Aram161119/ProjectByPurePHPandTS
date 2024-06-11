<?php

namespace App\Requests;

use App\Core\Request;

class CreateProductRequest extends Request
{
    /**
     * @return string[]
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|min:2|max:255',
            'type' => 'required|integer',
            'price' => 'required|integer',
        ];
    }
}