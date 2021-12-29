<?php declare(strict_types=1);

namespace BluefynInternational\ShipEngine\Tests\Util;

use BluefynInternational\ShipEngine\Util\ShipEngineLogger;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

/**
 * Class ShipEngineLoggerTest
 *
 * @covers \BluefynInternational\ShipEngine\Util\ShipEngineLogger
 * @package Util
 */
final class ShipEngineLoggerTest extends TestCase
{
    public function testLog()
    {
        $logger = new ShipEngineLogger();
        $this->assertInstanceOf(LoggerInterface::class, $logger);
    }
}
