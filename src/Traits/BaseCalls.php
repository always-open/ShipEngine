<?php

namespace BluefynInternational\ShipEngine\Traits;

use BluefynInternational\ShipEngine\DTO\PaginationLinks;
use BluefynInternational\ShipEngine\DTO\Shipment;
use BluefynInternational\ShipEngine\ShipEngineClient;
use BluefynInternational\ShipEngine\ShipEngineConfig;
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
