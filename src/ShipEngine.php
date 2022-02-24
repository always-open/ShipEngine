<?php

namespace BluefynInternational\ShipEngine;

use BluefynInternational\ShipEngine\Traits\Addresses;
use BluefynInternational\ShipEngine\Traits\Batches;
use BluefynInternational\ShipEngine\Traits\CarrierAccounts;
use BluefynInternational\ShipEngine\Traits\Carriers;
use BluefynInternational\ShipEngine\Traits\Downloads;
use BluefynInternational\ShipEngine\Traits\Insurance;
use BluefynInternational\ShipEngine\Traits\Labels;
use BluefynInternational\ShipEngine\Traits\Manifests;
use BluefynInternational\ShipEngine\Traits\PackageTypes;
use BluefynInternational\ShipEngine\Traits\Shipments;
use BluefynInternational\ShipEngine\Traits\ShippingRates;
use BluefynInternational\ShipEngine\Traits\Tags;
use BluefynInternational\ShipEngine\Traits\Tracking;
use BluefynInternational\ShipEngine\Traits\Warehouse;
use Exception;
use GuzzleHttp\Exception\GuzzleException;

class ShipEngine
{
    use Addresses;
    use Batches;
    use CarrierAccounts;
    use Carriers;
    use Downloads;
    use Labels;
    use Manifests;
    use PackageTypes;
    use Insurance;
    use Shipments;
    use ShippingRates;
    use Tags;
    use Tracking;
    use Warehouse;

    /**
     * ShipEngine SDK Version
     */
    public const VERSION = '1.0.0';

    /**
     * Global configuration for the ShipEngine API client, such as timeouts,
     * retries, page size, etc. This configuration applies to all method calls,
     * unless specifically overridden when calling a method.
     *
     * @var ShipEngineConfig
     */
    public ShipEngineConfig $config;

    /**
     * @param array|ShipEngineConfig|null $config [apiKey:string, baseUrl:string, pageSize:int, retries:int, timeout:int, eventListener:object]
     *
     * @throws Exception
     */
    public function __construct(array|ShipEngineConfig|null $config = null)
    {
        if (! $config instanceof ShipEngineConfig) {
            $config = new ShipEngineConfig($config ?? []);
        }

        $this->config = $config;
    }

    /**
     * Given some shipment details and rate options, this endpoint returns a list of rate quotes.
     * See: https://shipengine.github.io/shipengine-openapi/#operation/calculate_rates
     *
     * @param array $params An array of rate options and shipment details.
     * @param array|ShipEngineConfig|null $config Optional configuration overrides for this method call {apiKey:string,
     * baseUrl:string, pageSize:int, retries:int, timeout:int, client:HttpClient|null}
     *
     * @return array An array of Rate objects that correspond to the rate options and shipment details.
     *
     * @throws GuzzleException|Exception
     */
    public function getRatesWithShipmentDetails(array $params, array|ShipEngineConfig|null $config = null): array
    {
        return ShipEngineClient::post(
            'rates',
            $this->config->merge($config),
            $params,
        );
    }
}
