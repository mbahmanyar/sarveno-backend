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
        $items = $this->shoppingItemRepository->get();
        echo response($items);
    }

    public function show(int $id)
    {
        $item = $this->shoppingItemRepository->find($id);
        if (!$item) {
            return abort("Item not found", 404);
        }
        echo response($item);
    }

    public function store()
    {
        $headers = getallheaders();

        if ($headers['Content-Type'] !== 'application/json') {
            $data = $_POST;
        } else {
            // If the content type is JSON, we read the raw input
            $data = json_decode(file_get_contents('php://input'), true);
        }


        if (empty($data['name']) || empty($data['quantity'])) {
            return abort("Invalid input", 400);
        }

        $item = $this->shoppingItemRepository->create($data);
        if (!$item) {
            return abort("Failed to create item", 500);
        }

        echo response($item, 201);
    }
    
    
}