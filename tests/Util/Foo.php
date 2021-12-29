<?php

namespace BluefynInternational\ShipEngine\Tests\Util;

use BluefynInternational\ShipEngine\Util\Getters;

final class Foo implements \JsonSerializable
{
    use Getters;

    private string $bar = 'baz';

    #[\ReturnTypeWillChange]
    public function jsonSerialize() : array
    {
        return ['0' => 0, '1' => 1];
    }
}
