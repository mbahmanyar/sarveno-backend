<?php

namespace App\Forms;


use App\Exception\ValidationException;
use Core\Forms\Form;
use Core\Validator;

class CreateItemForm extends Form
{

    public $file;

    public function __construct(
        public int    $user_id,
        public string $name,
        public int    $quantity,
        public string $note = "",
        public bool   $is_checked = false,
        $file = "",
    )
    {
        $this->file = $file;
    }


    public static function validate($attributes): array
    {

        $instance = new static(
            $attributes['user_id'],
            $attributes['name'] ?? "",
            $attributes['quantity'] ?? 0,
            $attributes['note'] ?? "",
            $attributes['is_checked'] ?? false,
            $attributes['file'] ?? ""
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

        if (!empty($instance->file) && ($instance->file['error'] > 0)) {

            $fileErrorMessages = [
                'There is no error, the file uploaded with success',
                'The uploaded file exceeds the upload_max_filesize directive in php.ini',
                'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form',
                'The uploaded file was only partially uploaded',
                'No file was uploaded',
                'Missing a temporary folder',
                'Failed to write file to disk.',
                'A PHP extension stopped the file upload.'
            ];
            $instance->errors['file'] = $fileErrorMessages[$instance->file['error']] ?? 'An unknown error occurred while uploading the file.';
        }

        return $instance->toArray();
    }


}