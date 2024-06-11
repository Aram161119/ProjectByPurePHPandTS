<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\ErrorResponse;
use App\Exceptions\ValidationException;
use App\Managers\AdminManager;
use App\Requests\CreateAdminRequest;

class AdminController extends Controller
{
    /**
     * @return void
     */
    public function index()
    {
        $manager = new AdminManager();

        $data = $manager->index();

        return $this->successResponse($data);
    }

    /**
     * @return void
     */
    public function store()
    {
        try {
            $request = new CreateAdminRequest();

            if (!$request->validate()) {
                throw new ValidationException();
            }

            $data = $request->getData();

            $manager = new AdminManager();

            $criteria = [
                'value' => $data['email'],
                'field' => 'email',
                'operator' => '='
            ];

            if ($manager->find($criteria)) {
                throw new ValidationException('Email already used');
            }

            $manager->create($data);

            return $this->successResponse(code: 204);
        } catch (\Throwable $e) {
            return ErrorResponse::handle($e);
        }
    }
}
