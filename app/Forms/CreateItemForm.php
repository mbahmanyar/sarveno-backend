<?php

namespace App\Forms;


use App\Exception\ValidationException;
use Core\Forms\Form;
use Core\Validator;

class CreateItemForm extends Form
{



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
            $attributes['quantity'] ?? 0,
            $attributes['note'] ?? "",
            $attributes['is_checked'] ?? false
        );

        if ($instance->failed()) {
            throw new ValidationException($instance->errors);
        }

        return $instance->toArray();
    }




}