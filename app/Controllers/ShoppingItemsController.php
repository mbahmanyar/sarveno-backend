<?php

namespace App\Controllers;

use App\Forms\CreateItemForm;
use App\Forms\UpdateItemForm;
use App\Models\ShoppingItem;
use App\Repositories\ShoppingItemRepository;
use Core\Interfaces\AuthenticationInterface;

class ShoppingItemsController
{

    public function index()
    {
        require view_path('shopping-items.php');
    }

}