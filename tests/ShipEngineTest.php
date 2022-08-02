<?php

namespace AlwaysOpen\ShipEngine\Tests;

use AlwaysOpen\ShipEngine\ShipEngine;
use Orchestra\Testbench\TestCase as Orchestra;

/**
 * @covers \AlwaysOpen\ShipEngine\ShipEngineConfig
 * @covers \AlwaysOpen\ShipEngine\Util\Assert
 * @covers \AlwaysOpen\ShipEngine\Util\ShipEngineSerializer
 * @covers \AlwaysOpen\ShipEngine\ShipEngineConfig::__construct
 * @covers \AlwaysOpen\ShipEngine\Util\Assert::isApiKeyValid
 * @covers \AlwaysOpen\ShipEngine\Util\Assert::isTimeoutValid
 * @covers \AlwaysOpen\ShipEngine\ShipEngineConfig::merge
 * @covers \AlwaysOpen\ShipEngine\ShipEngine::__construct
 * @covers \AlwaysOpen\ShipEngine\ShipEngine::listCarriers
 * @covers \AlwaysOpen\ShipEngine\ShipEngineClient::deriveUserAgent
 * @covers \AlwaysOpen\ShipEngine\ShipEngineClient::get
 * @covers \AlwaysOpen\ShipEngine\ShipEngineClient::handleResponse
 * @covers \AlwaysOpen\ShipEngine\ShipEngineClient::sendRequest
 * @covers \AlwaysOpen\ShipEngine\ShipEngineClient::sendRequestWithRetries
 */
final class ShipEngineTest extends Orchestra
{
    public function testInstantiation(): void
    {
        $config = [
            'apiKey' => 'TEST_ycvJAgX6tLB1Awm9WGJmD8mpZ8wXiQ20WhqFowCk32s',
            'baseUrl' => 'https://api.shipengine.com',
            'pageSize' => 75,
            'retries' => 7,
            'timeout' => new \DateInterval('PT15S'),
        ];

        $instance = new ShipEngine($config);

        $this->assertInstanceOf(ShipEngine::class, $instance);

        $this->assertEquals($config['apiKey'], $instance->config->apiKey);
        $this->assertEquals($config['baseUrl'], $instance->config->baseUrl);
        $this->assertEquals($config['pageSize'], $instance->config->pageSize);
        $this->assertEquals($config['retries'], $instance->config->retries);
    }
}
