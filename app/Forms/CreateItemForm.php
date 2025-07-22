<?php

namespace App\Forms;


use App\Exception\ValidationException;
use Core\Validator;

class CreateItemForm
{

    protected array $errors = [];

    public function __construct(
        public string $name,
        public int    $quantity,
        public string $note = "",
        public bool   $is_checked = false
    )
    {

        if (!Validator::required($this->name)) {
            $this->errors['name'] = 'Name is required';
        }

        if (!Validator::min($this->name, 3)) {
            $this->errors['name'] = 'Name must be at least 3 characters long';
        }

//        if (!Validator::required($this->quantity)) {
//            $this->errors['quantity'] = 'Quantity is required';
//        }

        if (!Validator::min($this->quantity, 0)) {
            $this->errors['quantity'] = 'Minimum quantity is 0';
        }

        if (!empty($this->note) && !Validator::min($this->note, 3)) {
            $this->errors['note'] = 'Note must be at least 3 characters long';
        }
    }


    public static function validate($attributes): array
    {

        $instance = new static(
            $attributes['name'] ?? "",
            $attributes['quantity'] ?? -1,
            $attributes['note'] ?? "",
            $attributes['is_checked'] ?? false
        );

        if ($instance->failed()) {
            throw new ValidationException($instance->errors);
        }

        return $instance->toArray();
    }

    private function failed(): bool
    {
        return count($this->errors) > 0;
    }

    private function toArray()
    {
        return get_object_vars($this);
    }


}