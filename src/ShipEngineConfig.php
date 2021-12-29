<?php

namespace BluefynInternational\ShipEngine;

use BluefynInternational\ShipEngine\Util\Assert;
use DateInterval;
use Illuminate\Contracts\Support\Arrayable;

final class ShipEngineConfig implements \JsonSerializable, Arrayable
{
    public const DEFAULT_BASE_URI = 'https://api.shipengine.com/';

    public const DEFAULT_PAGE_SIZE = 50;

    public const DEFAULT_RETRIES = 1;

    public const DEFAULT_TIMEOUT = 'PT10S';

    public string $apiKey;

    public string $baseUrl;

    public int $pageSize;

    public int $retries;

    public bool $asObject = false;

    public DateInterval $timeout;

    /**
     * @param array $config [apiKey:string, baseUrl:string, pageSize:int, retries:int, timeout:DateInterval]
     */
    public function __construct(array $config = [])
    {
        $assert = new Assert();
        $api_key = $config['apiKey'] ?? config('shipengine.credentials.key');
        $assert->isApiKeyValid($api_key);
        $this->apiKey = $api_key;

        $retries = $config['retries'] ?? config('shipengine.retries') ?? self::DEFAULT_RETRIES;
        $assert->isRetriesValid($retries);
        $this->retries = $retries;

        $timeout = $config['timeout'] ?? new DateInterval(self::DEFAULT_TIMEOUT);
        $assert->isTimeoutValid($timeout);
        $this->timeout = $timeout;

        $this->asObject = boolval($config['asObject'] ?? false);

        $this->baseUrl = $config['baseUrl'] ?? self::getBaseUri();
        $this->pageSize = $config['pageSize'] ?? self::DEFAULT_PAGE_SIZE;
    }

    /**
     * Merge in method level config into the global config used by the **ShipEngine** object.
     *
     * @param array|ShipEngineConfig|null $newConfig
     *
     * @return $this
     */
    public function merge(array|ShipEngineConfig|null $newConfig = null): ShipEngineConfig
    {
        if ($newConfig instanceof ShipEngineConfig) {
            $newConfig = $newConfig->toArray();
        }

        if (empty($newConfig)) {
            return $this;
        }

        $config = array_merge($this->toArray(), $newConfig);

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
            'apiKey'   => $this->apiKey,
            'baseUrl'  => $this->baseUrl,
            'pageSize' => $this->pageSize,
            'retries'  => $this->retries,
            'timeout'  => $this->timeout->s,
            'asObject' => $this->asObject,
        ];
    }

    public static function getBaseUri() : string
    {
        return config('shipengine.endpoint.base') ?? self::DEFAULT_BASE_URI;
    }

    public function toArray()
    {
        return [
            'apiKey'   => $this->apiKey,
            'baseUrl'  => $this->baseUrl,
            'pageSize' => $this->pageSize,
            'retries'  => $this->retries,
            'timeout'  => $this->timeout,
            'asObject' => $this->asObject,
        ];
    }
}
