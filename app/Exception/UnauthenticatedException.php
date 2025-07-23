<?php

namespace App\Exception;

class UnauthenticatedException extends \Exception
{

    /**
     * @param string $string
     * @param int $int
     */
    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}