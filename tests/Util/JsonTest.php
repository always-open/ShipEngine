<?php

namespace BluefynInternational\ShipEngine\Tests\Util;

use BluefynInternational\ShipEngine\Util\Json;

use PHPUnit\Framework\TestCase;

/**
 * @covers \BluefynInternational\ShipEngine\Util\JSON::encode
 * @covers \BluefynInternational\ShipEngine\Util\JSON::encodeArray
 * @covers \BluefynInternational\ShipEngine\Util\JSON::jsonize
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
