<?php

namespace App\Models;

use Core\Model;

class ShoppingItem extends Model
{
    public function __construct(
        public ?int    $id,
        public int    $user_id, // Assuming user_id is not part of the model but used in repository
        public string  $name,
        public string  $note,
        public int     $quantity,
        public bool    $is_checked = false,
        public ?string $created_at = null,
        public ?string $updated_at = null
    )
    {
    }

    public static function initiate(array $properties): static
    {
        return new static(
            $properties['id'] ?? null,
            $properties['user_id'] ?? null,
            $properties['name'] ?? '',
            $properties['note'] ?? '',
            $properties['quantity'] ?? 0,
            $properties['is_checked'] ?? false,
            $properties['created_at'] ?? time(),
            $properties['updated_at'] ?? time()
        );
    }



}