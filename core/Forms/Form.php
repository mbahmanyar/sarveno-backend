<?php

namespace Core\Forms;

abstract class Form
{

    protected array $errors = [];



    protected function failed(): bool
    {
        return count($this->errors) > 0;
    }

    protected function toArray()
    {
        return get_object_vars($this);
    }

}