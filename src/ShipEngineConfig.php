<?php

namespace BluefynInternational\ShipEngine;

use BluefynInternational\ShipEngine\Message\ValidationException;
use BluefynInternational\ShipEngine\Util\Assert;
use DateInterval;

/**
 * Class ShipEngineConfig - This is the configuration object for the ShipEngine object and it's properties are
 * used throughout this SDK.
 *
 * @package ShipEngine
 */
final class ShipEngineConfig implements \JsonSerializable
{
    /**
     * The default base uri for the ShipEngineClient.
     */
    public const DEFAULT_BASE_URI = 'https://api.shipengine.com/';

    /**
     * Default page size for responses from ShipEngine API.
     */
    public const DEFAULT_PAGE_SIZE = 50;

    /**
     * Default number of retries the ShipEngineClient should make before returning an exception.
     */
    public const DEFAULT_RETRIES = 1;

    /**
     * Default timeout for the ShipEngineClient in seconds as a **DateInterval**.
     */
    public const DEFAULT_TIMEOUT = 'PT10S';


    /**
     * A ShipEngine API Key, sandbox API Keys start with **TEST_**.
     *
     * @var string
     */
    public string $apiKey;

    /**
     * The configured base uri for the ShipEngineClient.
     *
     * @var string
     */
    public string $baseUrl;

    /**
     * Configured page size for responses from ShipEngine API.
     *
     * @var int
     */
    public int $pageSize;

    /**
     * Configured number of retries the ShipEngineClient should make before returning an exception.
     *
     * @var int
     */
    public int $retries;

    /**
     * Configured timeout for the ShipEngineClient in seconds as a **DateInterval**.
     *
     * @var DateInterval
     */
    public DateInterval $timeout;

    /**
     * ShipEngineConfig constructor.
     *
     * @param array $config {apiKey:string, baseUrl:string, pageSize:int,
     * retries:int, timeout:DateInterval}
     */
    public function __construct(array $config = [])
    {
        $assert = new Assert();
        $assert->isApiKeyValid($config);
        $this->apiKey = $config['apiKey'];


        $retries = $config['retries'] ?? self::DEFAULT_RETRIES;
        if ($retries < 0) {
            throw new ValidationException(
                'Retries must be zero or greater.',
                null,
                'shipengine',
                'validation',
                'invalid_field_value'
            );
        }

        $this->retries = $retries;

        $timeout = $config['timeout'] ?? new DateInterval(self::DEFAULT_TIMEOUT);
        if (! $timeout instanceof DateInterval) {
            throw new ValidationException(
                'Timeout is not a DateInterval.',
                null,
                'shipengine',
                'validation',
                'invalid_field_value'
            );
        }

        $assert->isTimeoutValid($timeout);
        $this->timeout = $timeout;

        $this->baseUrl = $config['baseUrl'] ?? self::getBaseUri();
        $this->pageSize = $config['pageSize'] ?? self::DEFAULT_PAGE_SIZE;
    }

    /**
     * Merge in method level config into the global config used by the **ShipEngine** object.
     *
     * @param array|null $newConfig
     * @return $this
     */
    public function merge(array|null $newConfig = null): ShipEngineConfig
    {
        if (! isset($newConfig)) {
            return $this;
        }

        $config = [];

        $config['apiKey'] = $newConfig['apiKey'] ?? $this->apiKey;
        $config['baseUrl'] = $newConfig['baseUrl'] ?? $this->baseUrl;
        $config['pageSize'] = $newConfig['pageSize'] ?? $this->pageSize;
        $config['retries'] = $newConfig['retries'] ?? $this->retries;
        $config['timeout'] = $newConfig['timeout'] ?? $this->timeout;

        return new ShipEngineConfig($config);
    }

    /**
     * Specify data which should be serialized to JSON
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     */
    #[\ReturnTypeWillChange]
    public function jsonSerialize() : array
    {
        return [
          'apiKey' => $this->apiKey,
          'baseUrl' => $this->baseUrl,
          'pageSize' => $this->pageSize,
          'retries' => $this->retries,
          'timeout' => $this->timeout->s,
        ];
    }

    public static function getBaseUri() : string
    {
        return config('shipengine.endpoint.base') ?? self::DEFAULT_BASE_URI;
    }
}
