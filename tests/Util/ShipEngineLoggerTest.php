<?php

namespace AlwaysOpen\ShipEngine\Tests\Util;

use AlwaysOpen\ShipEngine\Util\ShipEngineLogger;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

/**
 * Class ShipEngineLoggerTest
 *
 * @covers \AlwaysOpen\ShipEngine\Util\ShipEngineLogger
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
