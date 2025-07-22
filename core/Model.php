<?php

namespace Core;

abstract class Model
{
    /**
     * Initialize the model with properties.
     *
     * @param array $properties
     * @return static
     */
    abstract public static function initiate(array $properties): static;

    /**
     * Get the properties of the model as an array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return get_object_vars($this);
    }

}