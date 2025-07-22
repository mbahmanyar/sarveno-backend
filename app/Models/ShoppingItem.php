<?php

namespace App\Models;

class ShoppingItem
{
    public function __construct(
        public ?int    $id,
        public string  $name,
        public string  $note,
        public int     $quantity,
        public bool    $is_checked = false,
        public ?string $created_at = null,
        public ?string $updated_at = null
    )
    {
    }

}