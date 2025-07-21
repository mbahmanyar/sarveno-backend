<?php

namespace App\Repositories;

class ShoppingItemRepository
{

    private \Core\Database $db;

    public function __construct()
    {
        $this->db = new \Core\Database();
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