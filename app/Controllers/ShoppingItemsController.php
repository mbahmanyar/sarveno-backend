<?php

namespace App\Controllers;

use App\Repositories\ShoppingItemRepository;
use Core\Application;

class ShoppingItemsController
{

    public function __construct(
        private ShoppingItemRepository $shoppingItemRepository
    )
    {
    }

    public function index()
    {
        return $this->shoppingItemRepository->get();
    }

    public function show(int $id)
    {
        $item = $this->shoppingItemRepository->find($id);
        if (!$item) {
            return abort("Item not found", 404);
        }
        return $item;
    }

}