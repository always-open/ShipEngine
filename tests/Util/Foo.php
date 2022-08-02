<?php

namespace AlwaysOpen\ShipEngine\Tests\Util;

use AlwaysOpen\ShipEngine\Util\Getters;

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
