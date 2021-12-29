<?php declare(strict_types=1);

namespace BluefynInternational\ShipEngine\Tests\Util;

use BluefynInternational\ShipEngine\Util\IsoString;

use PHPUnit\Framework\TestCase;

/**
 * @covers \BluefynInternational\ShipEngine\Util\IsoString
 */
final class IsoStringTest extends TestCase
{
    public function testCastToString(): void
    {
        $str = new IsoString('foo bar');
        $strs = explode(' ', (string) $str);

        $this->assertCount(2, $strs);
    }

    public function testHasTime(): void
    {
        $str = new IsoString('2020-01-01T00:00:00Z');
        $this->assertTrue($str->hasTime());

        $str = new IsoString('2020-01-01');
        $this->assertFalse($str->hasTime());
    }

    public function testHasTimezone(): void
    {
        $str = new IsoString('2020-01-01T00:00:00Z');
        $this->assertTrue($str->hasTimezone());

        $str = new IsoString('2020-01-01T00:00:00+00:00');
        $this->assertTrue($str->hasTimezone());

        $str = new IsoString('2020-01-01T00:00:00-00:00');
        $this->assertTrue($str->hasTimezone());
        
        $str = new IsoString('2020-01-01');
        $this->assertFalse($str->hasTimezone());

        $str = new IsoString('2020-01-01T00:00:00');
        $this->assertFalse($str->hasTimezone());
    }
}
