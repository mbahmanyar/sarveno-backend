<?php

namespace App\Controllers;

use App\Models\ShoppingItem;
use App\Repositories\ShoppingItemRepository;

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
        $item = $this->shoppingItemRepository->findOrFail($id);

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

        $model = ShoppingItem::initiate($data);

        $item = $this->shoppingItemRepository->save($model);

        if (!$item) {
            // todo must change
            return abort("Failed to create item", 500);
        }

        echo response($item, 201);
    }


}