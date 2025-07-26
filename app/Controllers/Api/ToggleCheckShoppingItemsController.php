<?php

namespace App\Controllers\Api;

class ToggleCheckShoppingItemsController
{

    public function __construct(
        private \App\Repositories\ShoppingItemRepository $shoppingItemRepository,
    )
    {
    }

    public function update(int $id)
    {
        $model = $this->shoppingItemRepository->findOrFail($id);

        $model->fill([
            'is_checked' => !$model->is_checked,
        ]);

        $item = $this->shoppingItemRepository->save($model);

        echo response($item, 200);
    }

}