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

    public function findById($id)
    {
        return $this->db->query("SELECT * FROM shopping_items WHERE id={$id}")->fetch();
    }

}