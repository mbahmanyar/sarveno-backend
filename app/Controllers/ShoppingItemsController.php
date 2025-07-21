<?php

namespace App\Controllers;

use App\Repositories\ShoppingItemRepository;

class ShoppingItemsController
{

    public function index()
    {
        return new ShoppingItemRepository()->get();
    }

    public function show()
    {
        var_dump("show");
        die();
    }

}