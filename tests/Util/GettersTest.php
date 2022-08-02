<?php

namespace AlwaysOpen\ShipEngine\Tests\Util;

use PHPUnit\Framework\TestCase;

/**
 * @covers \AlwaysOpen\ShipEngine\Util\Getters
 */
final class GettersTest extends TestCase
{
    public function testFoundGetter(): void
    {
        $foo = new Foo();
        $this->assertEquals('baz', $foo->bar);
    }

    public function testUnfoundGetter(): void
    {
        $this->expectException(\RuntimeException::class);
        $foo = new Foo();
        $foo->baz;
    }
}
