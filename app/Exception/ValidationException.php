<?php

namespace App\Exception;

class ValidationException extends \Exception
{

    public function __construct(public array $errors, string $message = "Invalidate inputs.", int $code = 427)
    {
        parent::__construct($message, $code);
    }
}