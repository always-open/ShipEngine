<?php declare(strict_types=1);

namespace BluefynInternational\ShipEngine\Tests\Util;

use PHPUnit\Framework\TestCase;

use BluefynInternational\ShipEngine\Util\Arr;

/**
 * @covers \BluefynInternational\ShipEngine\Util\Arr::flatten
 * @covers \BluefynInternational\ShipEngine\Util\Arr::subArray
 */
final class ArrTest extends TestCase
{
    public function testFlatten(): void
    {
        $old = array(
            array(1),
            array(2),
            array(3)
        );

        $new = Arr::flatten($old);

        $this->assertCount(3, $new);
        $this->assertContainsOnly('int', $new);
    }
    
    public function testSubArray(): void
    {
        $old = array(
            'one' => 1,
            'two' => 2,
            'three' => 3
        );

        $new = Arr::subArray($old, 'one', 'two');
        
        $this->assertArrayHasKey('one', $new);
        $this->assertArrayHasKey('two', $new);
        $this->assertArrayNotHasKey('three', $new);
    }
}
