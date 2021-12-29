<?php

namespace BluefynInternational\ShipEngine\Tests;

use BluefynInternational\ShipEngine\ShipEngine;
use Orchestra\Testbench\TestCase as Orchestra;

/**
 * @covers \BluefynInternational\ShipEngine\ShipEngineConfig
 * @covers \BluefynInternational\ShipEngine\Util\Assert
 * @covers \BluefynInternational\ShipEngine\Util\ShipEngineSerializer
 * @covers \BluefynInternational\ShipEngine\ShipEngineConfig::__construct
 * @covers \BluefynInternational\ShipEngine\Util\Assert::isApiKeyValid
 * @covers \BluefynInternational\ShipEngine\Util\Assert::isTimeoutValid
 * @covers \BluefynInternational\ShipEngine\ShipEngineConfig::merge
 * @covers \BluefynInternational\ShipEngine\ShipEngine::__construct
 * @covers \BluefynInternational\ShipEngine\ShipEngine::listCarriers
 * @covers \BluefynInternational\ShipEngine\ShipEngineClient::deriveUserAgent
 * @covers \BluefynInternational\ShipEngine\ShipEngineClient::get
 * @covers \BluefynInternational\ShipEngine\ShipEngineClient::handleResponse
 * @covers \BluefynInternational\ShipEngine\ShipEngineClient::sendRequest
 * @covers \BluefynInternational\ShipEngine\ShipEngineClient::sendRequestWithRetries
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
