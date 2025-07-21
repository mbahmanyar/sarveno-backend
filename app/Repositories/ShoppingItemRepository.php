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

    public function create(array $data): bool
    {
        $name = $data['name'];
        $price = $data['price'];
        $quantity = $data['quantity'];

        return $this->db->query("INSERT INTO shopping_items (name, price, quantity) VALUES ('{$name}', {$price}, {$quantity})");
    }

    public function update(int $id, array $data): bool
    {
        $updateQuery = array_reduce(array_keys($data), function ($carry, $item) use ($data) {
            return $carry . "{$item}={$data[$item]}, ";
        }, '');

        $updateQuery = trim($updateQuery, ', ');

        return $this->db->query("UPDATE shopping_items SET {$updateQuery} WHERE id={$id}");
    }

    public function delete(int $id): bool
    {
        return $this->db->query("DELETE FROM shopping_items WHERE id={$id}");
    }

}