<?php

namespace Core;

class Validator
{

    public static function required($value): bool
    {
        return !empty($value) || $value === '0';
    }

    public static function email($value): bool
    {
        return filter_var($value, FILTER_VALIDATE_EMAIL) !== false;
    }

    public static function max($value, int $max): bool
    {
        $value = trim($value);
        if (is_numeric($value)) {
            // check if value is a numeric
            return (int)$value <= $max;
        }
        return mb_strlen($value) <= $max;
    }

    public static function min($value, int $min): bool
    {
        $value = trim($value);
        if (is_numeric($value)) {
            // check if value is a numeric
            return (int)$value >= $min;
        }
        return mb_strlen($value) >= $min;
    }

}