<?php

namespace App\Controllers\Api;

use App\Forms\CreateItemForm;
use App\Models\ShoppingItem;
use App\Repositories\ShoppingItemRepository;
use Core\Interfaces\AuthenticationInterface;

class ShoppingItemsController
{

    public function __construct(
        private ShoppingItemRepository $shoppingItemRepository,
        private AuthenticationInterface $currentUser
    )
    {
    }

    public function index()
    {
        $items = $this->shoppingItemRepository->findByUserId($this->currentUser->id);
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

        $data = CreateItemForm::validate($data);

        $model = ShoppingItem::initiate($data);

        $item = $this->shoppingItemRepository->save($model);

        echo response($item, 201);
    }

    public function update(int $id)
    {
        $data = json_decode(file_get_contents('php://input'), true);

        $data = CreateItemForm::validate($data);

        $model = $this->shoppingItemRepository->findOrFail($id);

        $model->fill($data);

        $item = $this->shoppingItemRepository->save($model);

        echo response($item, 200);
    }


    public function delete(int $id)
    {
        $shoppingItem = $this->shoppingItemRepository->findOrFail($id);

        $this->shoppingItemRepository->delete($shoppingItem);

        response(data: $shoppingItem, code: 204);
    }

    public function list()
    {
        require path(DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'Views' . DIRECTORY_SEPARATOR . 'shopping-items.php');

    }


}