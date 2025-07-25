<?php

namespace App\Forms;


use App\Exception\ValidationException;
use Core\Forms\Form;
use Core\Validator;

class UpdateItemForm extends Form
{


    public function __construct(
        public int $user_id,
        public string $name,
        public int    $quantity,
        public string $note = "",
        public bool   $is_checked = false
    )
    {


    }


    public static function validate($attributes): array
    {

        $instance = new static(
            $attributes['user_id'],
            $attributes['name'] ?? "",
            $attributes['quantity'] ?? 0,
            $attributes['note'] ?? "",
            $attributes['is_checked'] ?? false
        );

        if (!Validator::required($instance->name)) {
            $instance->errors['name'] = 'Name is required';
        }

        if (!Validator::min($instance->name, 3)) {
            $instance->errors['name'] = 'Name must be at least 3 characters long';
        }

        if ((int)$instance->quantity < 0) {
            $instance->errors['quantity'] = 'Quantity is required';
        }

        if (!Validator::min($instance->quantity, 0)) {
            $instance->errors['quantity'] = 'Minimum quantity is 0';
        }

        if (!empty($instance->note) && !Validator::min($instance->note, 3)) {
            $instance->errors['note'] = 'Note must be at least 3 characters long';
        }

        if ($instance->failed()) {
            throw new ValidationException($instance->errors);
        }

        return $instance->toArray();
    }




}