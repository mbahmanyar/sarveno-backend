<?php

namespace App\Repositories;

use App\Models\ShoppingItem;


interface ShoppingItemRepositoryInterface
{
    public function get(): array;

    public function find(int|string $id): ShoppingItem|null;

    public function findOrFail(int|string $id): ShoppingItem;

    public function save(ShoppingItem $shoppingItem): ShoppingItem;

    public function create(ShoppingItem $shoppingItem): ShoppingItem;

    public function update(ShoppingItem $shoppingItem): ShoppingItem;

    public function delete(ShoppingItem $shoppingItem): bool;
}