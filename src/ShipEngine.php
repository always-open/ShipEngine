<?php

namespace BluefynInternational\ShipEngine;

use GuzzleHttp\Exception\GuzzleException;

class ShipEngine
{
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
     * Instantiates the ShipEngine class. The `apiKey` you pass in can be either
     * a ShipEngine sandbox or production API Key. (sandbox keys start with "TEST_)
     *
     * @param array|string|null $config Can be either a string that is your `apiKey` or an `array` {apiKey:string,
     * baseUrl:string, pageSize:int, retries:int, timeout:int, eventListener:object}
     */
    public function __construct(array|string|null $config = null)
    {
        $this->config = new ShipEngineConfig(
            is_string($config) ? array('apiKey' => $config) : $config
        );
    }

    /**
     * Fetch the carrier accounts connected to your ShipEngine Account.
     *
     * @param array|ShipEngineConfig|null $config Optional configuration overrides for this method call {apiKey:string,
     * baseUrl:string, pageSize:int, retries:int, timeout:int, client:HttpClient|null}
     *
     * @return array An array of **CarrierAccount** objects that correspond the to carrier accounts connected
     * to a given ShipEngine account.
     *
     * @throws GuzzleException
     */
    public function listCarriers(array|ShipEngineConfig|null $config = null): array
    {
        return ShipEngineClient::get(
            'carriers',
            $this->config->merge($config),
        );
    }

    /**
     * Address validation ensures accurate addresses and can lead to reduced shipping costs by preventing address
     * correction surcharges. ShipEngine cross references multiple databases to validate addresses and identify
     * potential deliverability issues.
     * See: https://shipengine.github.io/shipengine-openapi/#operation/validate_address
     *
     * @param array $params A list of addresses that are to be validated
     * @param array|ShipEngineConfig|null $config Optional configuration overrides for this method call {apiKey:string,
     * baseUrl:string, pageSize:int, retries:int, timeout:int, client:HttpClient|null}
     *
     * @return array An array of Address objects that correspond the to carrier accounts connected
     * to a given ShipEngine account.
     *
     * @throws GuzzleException
     */
    public function validateAddresses(array $params, array|ShipEngineConfig|null $config = null): array
    {
        return ShipEngineClient::post(
            'addresses/validate',
            $this->config->merge($config),
            $params,
        );
    }

    /**
     * When retrieving rates for shipments using the /rates endpoint, the returned information contains a rateId
     * property that can be used to generate a label without having to refill in the shipment information repeatedly.
     * See: https://shipengine.github.io/shipengine-openapi/#operation/create_label_from_rate
     *
     * @param string $rateId A rate identifier for the label
     * @param array $params An array of label params that will dictate the label display and level of verification.
     * @param array|ShipEngineConfig|null $config Optional configuration overrides for this method call {apiKey:string,
     * baseUrl:string, pageSize:int, retries:int, timeout:int, client:HttpClient|null}
     *
     * @return array A label that correspond the to shipment details for a rate id
     *
     * @throws GuzzleException
     */
    public function createLabelFromRate(
        string $rateId,
        array $params,
        array|ShipEngineConfig|null $config = null,
    ): array {
        return ShipEngineClient::post(
            "labels/rates/$rateId",
            $this->config->merge($config),
            $params,
        );
    }

    /**
     * Purchase and print a label for shipment.
     * https://shipengine.github.io/shipengine-openapi/#operation/create_label
     *
     * @param array $params An array of shipment details for the label creation.
     * @param array|ShipEngineConfig|null $config Optional configuration overrides for this method call {apiKey:string,
     * baseUrl:string, pageSize:int, retries:int, timeout:int, client:HttpClient|null}
     *
     * @return array A label that correspond the to shipment details
     *
     * @throws GuzzleException
     */
    public function createLabelFromShipmentDetails(array $params, array|ShipEngineConfig|null $config = null): array
    {
        return ShipEngineClient::post(
            'labels',
            $this->config->merge($config),
            $params,
        );
    }

    /**
     * Void label with a Label Id.
     * https://shipengine.github.io/shipengine-openapi/#operation/void_label
     *
     * @param string $labelId A label id
     * @param array|ShipEngineConfig|null $config Optional configuration overrides for this method call {apiKey:string,
     * baseUrl:string, pageSize:int, retries:int, timeout:int, client:HttpClient|null}
     *
     * @return array A voided label approval and message
     *
     * @throws GuzzleException
     */
    public function voidLabelWithLabelId(string $labelId, array|ShipEngineConfig|null $config = null): array
    {
        return ShipEngineClient::put(
            "labels/$labelId/void",
            $this->config->merge($config),
        );
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
     * @throws GuzzleException
     */
    public function getRatesWithShipmentDetails(array $params, array|ShipEngineConfig|null $config = null): array
    {
        return ShipEngineClient::post(
            'rates',
            $this->config->merge($config),
            $params,
        );
    }

    /**
     * Retrieve the label's tracking information with Label Id
     * See: https://shipengine.github.io/shipengine-openapi/#operation/get_tracking_log_from_label
     *
     * @param string $labelId A label id
     * @param array|ShipEngineConfig|null $config Optional configuration overrides for this method call {apiKey:string,
     * baseUrl:string, pageSize:int, retries:int, timeout:int, client:HttpClient|null}
     *
     * @return array An array of Tracking information corresponding to the Label Id.
     *
     * @throws GuzzleException
     */
    public function trackUsingLabelId(string $labelId, array|ShipEngineConfig|null $config = null): array
    {
        return ShipEngineClient::get(
            "labels/$labelId/track",
            $this->config->merge($config),
        );
    }

    /**
     * Retrieve the label's tracking information with Carrier Code and Tracking Number
     * See: https://shipengine.github.io/shipengine-openapi/#operation/get_tracking_log
     *
     * @param string $carrierCode Carrier code used to retrieve tracking information
     * @param string $trackingNumber The tracking number associated with a shipment
     * @param array|ShipEngineConfig|null $config Optional configuration overrides for this method call {apiKey:string,
     * baseUrl:string, pageSize:int, retries:int, timeout:int, client:HttpClient|null}
     * @return array An array of Tracking information corresponding to the Label Id.
     * @throws GuzzleException
     */
    public function trackUsingCarrierCodeAndTrackingNumber(
        string $carrierCode,
        string $trackingNumber,
        array|ShipEngineConfig $config = null,
    ): array {
        return ShipEngineClient::get(
            "tracking?carrier_code=$carrierCode&tracking_number=$trackingNumber",
            $this->config->merge($config),
        );
    }

    /**
     * @param array|null $params
     * @param array|ShipEngineConfig|null $config
     *
     * @return array
     *
     * @throws GuzzleException
     *
     * https://shipengine.github.io/shipengine-openapi/#operation/list_shipments
     */
    public function listShipments(
        array|null $params = null,
        array|ShipEngineConfig $config = null,
    ) : array {
        return ShipEngineClient::get(
            'shipments',
            $this->config->merge($config),
            $params,
        );
    }

    /**
     * @param array|null $params
     * @param array|ShipEngineConfig|null $config
     *
     * @return array
     *
     * @throws GuzzleException
     *
     * https://shipengine.github.io/shipengine-openapi/#operation/create_shipments
     */
    public function createShipment(
        array|null $params = null,
        array|ShipEngineConfig $config = null,
    ) : array {
        return ShipEngineClient::post(
            'shipments',
            $this->config->merge($config),
            $params,
        );
    }

    /**
     * @param string $external_id
     * @param array|ShipEngineConfig|null $config
     *
     * @return array
     *
     * @throws GuzzleException
     *
     * https://shipengine.github.io/shipengine-openapi/#operation/get_shipment_by_external_id
     */
    public function getShipmentByExternalID(
        string $external_id,
        array|ShipEngineConfig $config = null,
    ) : array {
        return ShipEngineClient::get(
            "shipments/external_shipment_id/$external_id",
            $this->config->merge($config),
        );
    }

    /**
     * @param array|null $params
     * @param array|ShipEngineConfig|null $config
     *
     * @return array
     *
     * @throws GuzzleException
     *
     * https://shipengine.github.io/shipengine-openapi/#operation/parse_shipment
     */
    public function parseShipment(
        array|null $params = null,
        array|ShipEngineConfig $config = null,
    ) : array {
        return ShipEngineClient::put(
            'shipments/recognize',
            $this->config->merge($config),
        );
    }

    /**
     * @param string $id
     * @param array|ShipEngineConfig|null $config
     *
     * @return array
     *
     * @throws GuzzleException
     *
     * https://shipengine.github.io/shipengine-openapi/#operation/get_shipment_by_id
     */
    public function getShipmentById(
        string $id,
        array|ShipEngineConfig $config = null,
    ) : array {
        return ShipEngineClient::get(
            "shipments/$id",
            $this->config->merge($config),
        );
    }

    /**
     * @param string $id
     * @param array $params
     * @param array|ShipEngineConfig|null $config
     *
     * @return array
     *
     * @throws GuzzleException
     *
     * https://shipengine.github.io/shipengine-openapi/#operation/update_shipment
     */
    public function updateShipmentById(
        string $id,
        array $params,
        array|ShipEngineConfig $config = null,
    ) : array {
        return ShipEngineClient::put(
            "shipments/$id",
            $this->config->merge($config),
            $params,
        );
    }

    /**
     * @param string $id
     * @param array|ShipEngineConfig|null $config
     *
     * @return array
     *
     * @throws GuzzleException
     *
     * https://shipengine.github.io/shipengine-openapi/#operation/cancel_shipments
     */
    public function cancelShipment(
        string $id,
        array|ShipEngineConfig $config = null,
    ) : array {
        return ShipEngineClient::put(
            "shipments/$id/cancel",
            $this->config->merge($config),
        );
    }

    /**
     * @param string $id
     * @param array|null $params
     * @param array|ShipEngineConfig|null $config
     *
     * @return array
     *
     * @throws GuzzleException
     *
     * https://shipengine.github.io/shipengine-openapi/#operation/list_shipment_rates
     */
    public function getShipmentRates(
        string $id,
        array|null $params = null,
        array|ShipEngineConfig $config = null,
    ) : array {
        return ShipEngineClient::get(
            "shipments/$id/rates",
            $this->config->merge($config),
            $params,
        );
    }

    /**
     * @param string $id
     * @param string $tag_name
     * @param array|ShipEngineConfig|null $config
     *
     * @return array
     *
     * @throws GuzzleException
     *
     * https://shipengine.github.io/shipengine-openapi/#operation/tag_shipment
     */
    public function addTagToShipment(
        string $id,
        string $tag_name,
        array|ShipEngineConfig $config = null,
    ) : array {
        return ShipEngineClient::post(
            "shipments/$id/tags/$tag_name",
            $this->config->merge($config),
        );
    }

    /**
     * @param string $id
     * @param string $tag_name
     * @param array|ShipEngineConfig|null $config
     *
     * @return array
     *
     * @throws GuzzleException
     *
     * https://shipengine.github.io/shipengine-openapi/#operation/untag_shipment
     */
    public function removeTagFromShipment(
        string $id,
        string $tag_name,
        array|ShipEngineConfig $config = null,
    ) : array {
        return ShipEngineClient::delete(
            "shipments/$id/tags/$tag_name",
            $this->config->merge($config),
        );
    }
}
