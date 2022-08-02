<?php

namespace AlwaysOpen\ShipEngine\Traits;

use AlwaysOpen\ShipEngine\DTO\PaginationLinks;
use AlwaysOpen\ShipEngine\ShipEngineClient;
use AlwaysOpen\ShipEngine\ShipEngineConfig;
use Exception;
use GuzzleHttp\Exception\GuzzleException;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

trait BaseCalls
{
    use listToObjects;

    /**
     * @throws UnknownProperties|GuzzleException|Exception
     */
    public function retrieveList(
        string $path,
        array|null $params,
        array|ShipEngineConfig $config,
        string $responseKey,
        string $responseType,
    ) : array {
        $config = $this->config->merge($config);

        $response = ShipEngineClient::get(
            $path,
            $config,
            $params,
        );

        if ($config->asObject && ! empty($response[$responseKey])) {
            $response[$responseKey] = $this->listToObjects($response[$responseKey], $responseType);
            $response['links'] = new PaginationLinks($response['links']);
        }

        return $response;
    }
}
