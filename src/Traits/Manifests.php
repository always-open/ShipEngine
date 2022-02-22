<?php

namespace BluefynInternational\ShipEngine\Traits;

use BluefynInternational\ShipEngine\DTO\CurrencyAmount;
use BluefynInternational\ShipEngine\DTO\Manifest;
use BluefynInternational\ShipEngine\DTO\PaginationLinks;
use BluefynInternational\ShipEngine\ShipEngineClient;
use BluefynInternational\ShipEngine\ShipEngineConfig;
use GuzzleHttp\Exception\GuzzleException;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

trait Manifests
{
    use listToObjects;

    /**
     * @throws UnknownProperties|GuzzleException
     */
    public function listManifests(
        array $params = [],
        array|ShipEngineConfig|null $config = null,
    ): array {
        $config = $this->config->merge($config);
        $response = ShipEngineClient::get(
            'manifests',
            $config,
            $params,
        );

        if ($config->asObject) {
            $response['manifests'] = $this->listToObjects($response['manifests'], Manifest::class);
            $response['links'] = new PaginationLinks($response['links']);
        }

        return $response;
    }

    /**
     * @throws UnknownProperties|GuzzleException
     */
    public function createManifest(
        array $payload = [],
        array|ShipEngineConfig|null $config = null,
    ): array|Manifest {
        $config = $this->config->merge($config);
        $response = ShipEngineClient::post(
            'manifests',
            $config,
            $payload,
        );

        if ($config->asObject) {
            return new Manifest($response);
        }

        return $response;
    }

    /**
     * @throws UnknownProperties|GuzzleException
     */
    public function getManifestById(
        string $manifestId,
        array|ShipEngineConfig|null $config = null,
    ): array|Manifest {
        $config = $this->config->merge($config);
        $response = ShipEngineClient::post(
            "manifests/$manifestId",
            $config,
        );

        if ($config->asObject) {
            return new Manifest($response);
        }

        return $response;
    }


}
