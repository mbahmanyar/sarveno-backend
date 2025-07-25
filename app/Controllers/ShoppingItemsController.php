<?php

namespace App\Controllers;

class ShoppingItemsController
{

    public function index()
    {
        require view_path("shopping-items.php");
    }

}