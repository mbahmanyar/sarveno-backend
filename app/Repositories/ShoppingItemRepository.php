<?php

namespace App\Repositories;

class ShoppingItemRepository
{

    public function __construct(
        private \Core\Database $db
    )
    {
    }


    public function get(): array
    {
        return $this->db->query("SELECT * FROM shopping_items")->fetchAll();
    }

    public function find($id): array
    {
        $result = $this->db->query("SELECT * FROM shopping_items WHERE id={$id}")->fetch();

        if (!$result) {
            throw new \App\Exception\NotFoundException("Item not found", 404);
        }

        return $result;
    }

    public function create(array $data): array
    {
        $name = $data['name'];
        $note = $data['note'];
        $quantity = $data['quantity'];

        $this->db->query("INSERT INTO shopping_items (name, note, quantity) VALUES (:name, :note, :quantity)", [
            'name' => $name,
            'note' => $note,
            'quantity' => $quantity
        ]);

        return $this->find($this->db->lastInsertId());
    }

    public function update(int $id, array $data): bool
    {
        // todo must handle with model
        $updateQuery = array_reduce(array_keys($data), function ($carry, $item) use ($data) {
            return $carry . "{$item}={$data[$item]}, ";
        }, '');

        $updateQuery = trim($updateQuery, ', ');

        return $this->db->query("UPDATE shopping_items SET {$updateQuery} WHERE id={$id}");
    }

    public function delete(int $id): bool
    {
        return $this->db->query("DELETE FROM shopping_items WHERE id=:id", ['id' => $id]);
    }

}