<?php

namespace BluefynInternational\ShipEngine\Traits;

trait listToObjects
{
    protected function listToObjects(array $list, string $class) : array
    {
        $objects = [];
        foreach ($list as $item) {
            $objects[] = new $class($item);
        }

        return $objects;
    }
}
