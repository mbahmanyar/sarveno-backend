<?php

namespace App\Models;

use Core\Model;

class ShoppingItem extends Model
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

    public static function initiate(array $properties): static
    {
        return new static(
            $properties['id'] ?? null,
            $properties['name'] ?? '',
            $properties['note'] ?? '',
            $properties['quantity'] ?? 0,
            $properties['is_checked'] ?? false,
            $properties['created_at'] ?? null,
            $properties['updated_at'] ?? null
        );
    }



}