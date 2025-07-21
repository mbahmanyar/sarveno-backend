<?php

namespace App\Controllers;

use App\Repositories\ShoppingItemRepository;
use Core\Application;

class ShoppingItemsController
{

    public function index()
    {
        return Application::$container->resolve(ShoppingItemRepository::class)->get();
    }

    public function show()
    {
        var_dump("show");
        die();
    }

}