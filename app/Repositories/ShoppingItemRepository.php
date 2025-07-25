<?php

namespace App\Repositories;

use App\Exception\NotFoundException;
use App\Models\ShoppingItem;
use App\Models\User;

class ShoppingItemRepository implements ShoppingItemRepositoryInterface
{

    public function __construct(
        private \Core\Database $db
    )
    {
    }

    /**
     * @return Array<ShoppingItem>
     */
    public function get(): array
    {
        return array_map(
            fn($item) => ShoppingItem::initiate($item),
            $this->db->query("SELECT * FROM shopping_items")->fetchAll()
        );
    }

    public function find(int|string $id): ShoppingItem|null
    {
        $result = $this->db->query("SELECT * FROM shopping_items WHERE id={$id}")->fetch();

        return $result ? ShoppingItem::initiate($result) : null;
    }

    public function findByUserId(int|User $user): array
    {

        $id = $user instanceof User ? $user->id : $user;

        return array_map(
            fn($item) => ShoppingItem::initiate($item),
            $this->db->query("SELECT * FROM shopping_items Where user_id=:user_id", ['user_id' => $id])->fetchAll()
        );
    }

    /**
     * @throws NotFoundException
     */
    public function findOrFail(int|string $id): ShoppingItem
    {
        $item = $this->find($id);
        if (!$item) {
            throw new \App\Exception\NotFoundException("Item not found", 404);
        }
        return $item;
    }

    public function save(ShoppingItem $shoppingItem): ShoppingItem
    {
        if ($shoppingItem->id) {
            return $this->update($shoppingItem);
        }

        return $this->create($shoppingItem);
    }

    public function create(ShoppingItem $shoppingItem): ShoppingItem
    {
        $this->db->query("INSERT INTO shopping_items (user_id,name, note, quantity, is_checked) VALUES (:user_id,:name, :note, :quantity, :is_checked)", [
            'user_id' => $shoppingItem->user_id,
            'name' => $shoppingItem->name,
            'note' => $shoppingItem->note,
            'quantity' => $shoppingItem->quantity,
            'is_checked' => (int) $shoppingItem->is_checked,
        ]);

        $shoppingItem->id = $this->db->lastInsertId();

        return $shoppingItem;
    }

    public function update(ShoppingItem $shoppingItem): ShoppingItem
    {

        $this->db->query("UPDATE shopping_items SET name=:name, note=:note, quantity=:quantity, is_checked=:is_checked, updated_at=:updated_at WHERE id=:id", [
            'name' => $shoppingItem->name,
            'note' => $shoppingItem->note,
            'quantity' => $shoppingItem->quantity,
            'id' => $shoppingItem->id,
            'is_checked' => (int) $shoppingItem->is_checked,
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        return $shoppingItem;
    }

    public function delete(ShoppingItem $shoppingItem): bool
    {
        $this->db->query("DELETE FROM shopping_items WHERE id=:id", ['id' => $shoppingItem->id]);
        return true;
    }

}