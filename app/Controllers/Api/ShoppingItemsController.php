<?php

namespace App\Controllers\Api;

use App\Forms\CreateItemForm;
use App\Forms\UpdateItemForm;
use App\Models\ShoppingItem;
use App\Repositories\ShoppingItemRepository;
use Core\Interfaces\AuthenticationInterface;

class ShoppingItemsController
{

    public function __construct(
        private ShoppingItemRepository  $shoppingItemRepository,
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


        if (strpos($headers['Content-Type'], 'multipart/form-data') !== false) {

            $data = [
                'name' => $_POST['name'] ?? '',
                'note' => $_POST['note'] ?? '',
                'quantity' => $_POST['quantity'] ?? 1,
                'file' => $_FILES['file'] ?? null,
            ];

        } elseif ($headers['Content-Type'] !== 'application/json') {
            $data = $_POST;

        } else {
            // If the content type is JSON, we read the raw input
            $data = json_decode(file_get_contents('php://input'), true);
        }

        $data = CreateItemForm::validate([...$data, 'user_id' => $this->currentUser->id]);


        $uploadDir = '/public/storage';
        $extension = pathinfo($data['file']['name'], PATHINFO_EXTENSION);
        $fileName = uniqid(more_entropy: false) . '.' . $extension;
        $filePath = "{$uploadDir}/{$fileName}";

        if (!move_uploaded_file($data['file']['tmp_name'], path($filePath))) {
            abort('File upload failed.');
        }

        $data['file'] = $filePath;

        $model = ShoppingItem::initiate($data);

        $item = $this->shoppingItemRepository->save($model);


        echo response($item, 'The item was added.', 201);

    }

    public function update(int $id)
    {
        $data = json_decode(file_get_contents('php://input'), true);


        $data = UpdateItemForm::validate([...$data, 'user_id' => $this->currentUser->id]);


        $model = $this->shoppingItemRepository->findOrFail($id);

        $model->fill($data);

        $item = $this->shoppingItemRepository->save($model);


        echo response($item, 'The item was updated successfully.', 200);

    }


    public function delete(int $id)
    {
        $shoppingItem = $this->shoppingItemRepository->findOrFail($id);

        if($shoppingItem->file && !$shoppingItem->deleteFile()) {
            abort("The file cannot be deleted.");
        }

        $this->shoppingItemRepository->delete($shoppingItem);

        response(data: $shoppingItem, code: 204);
    }

}