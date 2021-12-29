<?php declare(strict_types=1);

namespace BluefynInternational\ShipEngine\Tests\Util;

use BluefynInternational\ShipEngine\Util\Getters;

final class Foo implements \JsonSerializable
{
    use Getters;

    private string $bar = 'baz';

    #[\ReturnTypeWillChange]
    public function jsonSerialize() : array
    {
        return array('0' => 0, '1' => 1);
    }
}
