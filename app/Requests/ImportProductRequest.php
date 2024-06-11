<?php

namespace App\Requests;

use App\Core\Request;

class ImportProductRequest extends Request
{
    /**
     * @return string[]
     */
    public function rules(): array
    {
        return [
            'file' => 'required|file',
        ];
    }
}