<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\ErrorResponse;
use App\Exceptions\ValidationException;
use App\Managers\AdminManager;
use App\Managers\ProductManager;
use App\Requests\CreateProductRequest;
use App\Requests\ImportProductRequest;
use App\Requests\ListProductRequest;

class ProductController extends Controller
{
    /**
     * @return false|string
     */
    public function index(): bool|string
    {
        $request = new ListProductRequest();
        $manager = new ProductManager();

        $search = [];

        $isRoot = 'aram.m@invo.am' === $_SESSION['admin']; //TODO use global method for get root email

        if (!$isRoot) {
            $criteria = [
                'value' => $_SESSION['admin'],
                'field' => 'email',
                'operator' => '='
            ];

            $adminManager = new AdminManager();
            $admin = $adminManager->find($criteria);

            $search = [
                'admin_id' => ['=', $admin['id']]
            ];
        }

        $data = $manager->index(search: $search, sorting: $request->getSort());

        return $this->successResponse($data);
    }

    /**
     * @return bool|string|void
     */
    public function store()
    {
        try {
            $request = new CreateProductRequest();

            if (!$request->validate()) {
                throw new ValidationException();
            }

            $manager = new ProductManager();
            $adminManager = new AdminManager();

            $data = $request->getData();

            $criteria = [
                'value' => $_SESSION['admin'],
                'field' => 'email',
                'operator' => '='
            ];

            $admin = $adminManager->find($criteria);

            $data['admin_id'] = $admin['id'];

            $manager->create($data);

            return $this->successResponse(code: 204);
        } catch (\Throwable $e) {
            return ErrorResponse::handle($e);
        }
    }

    public function import()
    {
        try {
            $request = new ImportProductRequest();

            if (!$request->validate()) {
                throw new ValidationException();
            }

            $manager = new ProductManager();
            $adminManager = new AdminManager();

            $data = $request->getFiles();

            $criteria = [
                'value' => $_SESSION['admin'],
                'field' => 'email',
                'operator' => '='
            ];

            $admin = $adminManager->find($criteria);

            $manager->import($admin['id'], $data);
        }  catch (\Throwable $e) {
            return ErrorResponse::handle($e);
        }
    }
}
