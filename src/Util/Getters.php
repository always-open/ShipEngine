<?php

namespace AlwaysOpen\ShipEngine\Util;

/**
 * Expose getters for private properties.
 */
trait Getters
{
    public function __get(string $property) : mixed
    {
        if (property_exists($this, $property)) {
            return $this->$property;
        }

        throw new \RuntimeException("Retrieving the field/member $property is not valid for this entity.");
    }
}
