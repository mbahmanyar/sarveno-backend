<?php

namespace App\Exception;

class NotFoundException extends \Exception
{

    public function __construct(string $message = "Not Found", int $code = 404)
    {
        parent::__construct($message, $code);
    }

    public function render(): string
    {
        http_response_code($this->getCode());
        header('Content-Type: application/json; charset=utf-8');

        return json_encode([
            'code' => $this->getCode(),
            'message' => $this->getMessage(),
            'success' => false,
        ]);
    }

}