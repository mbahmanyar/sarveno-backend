<?php

namespace Core\Interfaces;

use App\Models\ShoppingItem;

interface RepositoryInterface
{
    public function get(): array;

    public function find(int|string $id): ShoppingItem|null;

    public function findOrFail(int|string $id): ShoppingItem;

    public function save(ShoppingItem $shoppingItem): ShoppingItem;

    public function create(ShoppingItem $shoppingItem): ShoppingItem;

    public function update(ShoppingItem $shoppingItem): ShoppingItem;

    public function delete(ShoppingItem $shoppingItem): bool;
}