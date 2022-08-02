<?php

namespace AlwaysOpen\ShipEngine\Tests\Util;

use AlwaysOpen\ShipEngine\Util\Json;

use PHPUnit\Framework\TestCase;

/**
 * @covers \AlwaysOpen\ShipEngine\Util\JSON::encode
 * @covers \AlwaysOpen\ShipEngine\Util\JSON::encodeArray
 * @covers \AlwaysOpen\ShipEngine\Util\JSON::jsonize
 */
final class JsonTest extends TestCase
{
    public function testEncode(): void
    {
        $foo = new Foo();
        
        $json_string = Json::encode($foo, ['1', 'one']);

        $this->assertEquals('{"0":0,"one":1}', $json_string);
    }

    public function testEncodeArray(): void
    {
        $foos = [new Foo(), new Foo()];

        $json_string = Json::encodeArray($foos, ['0', 'zero']);

        $this->assertEquals('[{"1":1,"zero":0},{"1":1,"zero":0}]', $json_string);
    }
}
