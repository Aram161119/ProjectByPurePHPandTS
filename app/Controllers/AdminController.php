<?php

namespace App\Controllers;

use App\Models\Admin;

class AdminController
{
    public function index()
    {
        // Retrieve all admins and pass to the view (assuming a view function is available)
        $admins = Admin::getAll();
        // Render the view (this assumes you have a rendering method)
        // Example: view('admin.index', ['admins' => $admins]);
        echo '<pre>';
        print_r($admins);
        echo '</pre>';
    }

    public function create()
    {
        // Render a form for creating a new admin
        // Example: view('admin.create');
        echo "Create Admin Form";
    }

    public function store()
    {
        // Handle the form submission for creating a new admin
        $data = [
            'name' => $_POST['name'],
            'email' => $_POST['email'],
            'password' => password_hash($_POST['password'], PASSWORD_BCRYPT),
        ];

        Admin::create($data);

        // Redirect to admin index (you may need to adjust the path)
        header('Location: /admin');
    }
}
