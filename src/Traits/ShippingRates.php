<?php

namespace BluefynInternational\ShipEngine\Traits;

use BluefynInternational\ShipEngine\DTO\BulkRateResponse;
use BluefynInternational\ShipEngine\DTO\ShipmentRate;
use BluefynInternational\ShipEngine\DTO\ShippingRateRequestResponse;
use BluefynInternational\ShipEngine\ShipEngineClient;
use BluefynInternational\ShipEngine\ShipEngineConfig;
use Exception;
use GuzzleHttp\Exception\GuzzleException;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

trait ShippingRates
{
    use listToObjects;

    /**
     * @see https://shipengine.github.io/shipengine-openapi/#operation/calculate_rates
     *
     * @throws UnknownProperties|GuzzleException|Exception
     */
    public function getShippingRates(
        array $payload,
        array|ShipEngineConfig|null $config = null,
    ): array|ShippingRateRequestResponse {
        $config = $this->config->merge($config);
        $response = ShipEngineClient::post(
            'rates',
            $config,
            $payload
        );

        if ($config->asObject) {
            return new ShippingRateRequestResponse($response);
        }

        return $response;
    }

    /**
     * @see https://shipengine.github.io/shipengine-openapi/#operation/compare_bulk_rates
     *
     * @throws UnknownProperties|GuzzleException|Exception
     */
    public function getBulkRates(
        array $payload,
        array|ShipEngineConfig|null $config = null,
    ): array|BulkRateResponse {
        $config = $this->config->merge($config);
        $response = ShipEngineClient::post(
            'rates/bulk',
            $config,
            $payload
        );

        if ($config->asObject) {
            return new BulkRateResponse($response);
        }

        return $response;
    }

    /**
     * @see https://shipengine.github.io/shipengine-openapi/#operation/estimate_rates
     *
     * @throws GuzzleException|Exception
     */
    public function estimateRates(
        array $payload,
        array|ShipEngineConfig|null $config = null,
    ): array {
        $config = $this->config->merge($config);
        $response = ShipEngineClient::post(
            'rates/estimate',
            $config,
            $payload
        );

        if ($config->asObject) {
            $response = $this->listToObjects($response, ShipmentRate::class);
        }

        return $response;
    }

    /**
     * @see https://shipengine.github.io/shipengine-openapi/#operation/get_rate_by_id
     *
     * @throws UnknownProperties|GuzzleException
     */
    public function getRateById(
        string $rate_id,
        array|ShipEngineConfig|null $config = null,
    ): array|ShipmentRate {
        $config = $this->config->merge($config);
        $response = ShipEngineClient::post(
            "rates/$rate_id",
            $config,
        );

        if ($config->asObject) {
            return new ShipmentRate($response);
        }

        return $response;
    }
}
