<?php

namespace AlwaysOpen\ShipEngine;

use AlwaysOpen\ShipEngine\Traits\Addresses;
use AlwaysOpen\ShipEngine\Traits\Batches;
use AlwaysOpen\ShipEngine\Traits\CarrierAccounts;
use AlwaysOpen\ShipEngine\Traits\Carriers;
use AlwaysOpen\ShipEngine\Traits\Downloads;
use AlwaysOpen\ShipEngine\Traits\Insurance;
use AlwaysOpen\ShipEngine\Traits\Labels;
use AlwaysOpen\ShipEngine\Traits\Manifests;
use AlwaysOpen\ShipEngine\Traits\PackageTypes;
use AlwaysOpen\ShipEngine\Traits\Shipments;
use AlwaysOpen\ShipEngine\Traits\ShippingRates;
use AlwaysOpen\ShipEngine\Traits\Tags;
use AlwaysOpen\ShipEngine\Traits\Tracking;
use AlwaysOpen\ShipEngine\Traits\Warehouse;
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
