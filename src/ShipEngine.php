<?php

namespace BluefynInternational\ShipEngine;

use BluefynInternational\ShipEngine\DTO\Label;
use BluefynInternational\ShipEngine\DTO\Shipment;
use BluefynInternational\ShipEngine\DTO\TrackingInformation;
use BluefynInternational\ShipEngine\DTO\VoidLabel;
use GuzzleHttp\Exception\GuzzleException;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

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
     * @param array|ShipEngineConfig|null $config [apiKey:string, baseUrl:string, pageSize:int, retries:int, timeout:int, eventListener:object]
     */
    public function __construct(array|ShipEngineConfig|null $config = null)
    {
        if (! $config instanceof ShipEngineConfig) {
            $config = new ShipEngineConfig($config ?? []);
        }

        $this->config = $config;
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
     * @see https://shipengine.github.io/shipengine-openapi/#operation/list_labels
     * @throws GuzzleException|UnknownProperties
     */
    public function listLabels(
        array $params = [],
        array|ShipEngineConfig|null $config = null,
    ) : array {
        $config = $this->config->merge($config);

        $response = ShipEngineClient::get(
            'labels',
            $config,
            $params,
        );

        if ($config->asObject && ! empty($response['labels'])) {
            $response['labels'] = $this->labelsToObjects($response['labels']);
        }

        return $response;
    }

    /**
     * @see https://shipengine.github.io/shipengine-openapi/#operation/create_label
     * @throws GuzzleException|UnknownProperties
     */
    public function purchaseLabel(
        array $params,
        array|ShipEngineConfig|null $config = null,
    ) : array|Label {
        $config = $this->config->merge($config);
        $response = ShipEngineClient::post(
            'labels',
            $this->config->merge($config),
            $params,
        );

        if ($config->asObject) {
            return new Label($response);
        }

        return $response;
    }

    /**
     * @see https://shipengine.github.io/shipengine-openapi/#operation/get_label_by_external_shipment_id
     * @throws GuzzleException|UnknownProperties
     */
    public function getLabelByExternalShipmentId(
        string $externalShipmentId,
        array $params = [],
        array|ShipEngineConfig|null $config = null,
    ) : array|Label {
        $config = $this->config->merge($config);

        $response = ShipEngineClient::get(
            "labels/external_shipment_id/{$externalShipmentId}",
            $this->config->merge($config),
            $params,
        );

        if ($config->asObject) {
            return new Label($response);
        }

        return $response;
    }

    /**
     * @see https://shipengine.github.io/shipengine-openapi/#operation/create_label_from_rate
     * @throws GuzzleException|UnknownProperties
     */
    public function purchaseLabelWithRateId(
        string $rateId,
        array $params = [],
        array|ShipEngineConfig|null $config = null,
    ) : array|Label {
        $config = $this->config->merge($config);

        $response = ShipEngineClient::post(
            "labels/rates/{$rateId}",
            $this->config->merge($config),
            $params,
        );

        if ($config->asObject) {
            return new Label($response);
        }

        return $response;
    }

    /**
     * @see https://shipengine.github.io/shipengine-openapi/#operation/create_label_from_shipment
     * @throws GuzzleException|UnknownProperties
     */
    public function purchaseLabelWithShipmentId(
        string $shipmentId,
        array $params = [],
        array|ShipEngineConfig|null $config = null,
    ) : array|Label {
        $config = $this->config->merge($config);

        $response = ShipEngineClient::post(
            "labels/shipment/{$shipmentId}",
            $this->config->merge($config),
            $params,
        );

        if ($config->asObject) {
            return new Label($response);
        }

        return $response;
    }

    /**
     * @see https://shipengine.github.io/shipengine-openapi/#operation/get_label_by_id
     * @throws GuzzleException|UnknownProperties
     */
    public function getLabelById(
        string $labelId,
        array $params = [],
        array|ShipEngineConfig|null $config = null,
    ) : array|Label {
        $config = $this->config->merge($config);

        $response = ShipEngineClient::get(
            "labels/{$labelId}",
            $this->config->merge($config),
            $params,
        );

        if ($config->asObject) {
            return new Label($response);
        }

        return $response;
    }

    /**
     * @see https://shipengine.github.io/shipengine-openapi/#operation/create_return_label
     * @throws GuzzleException|UnknownProperties
     */
    public function createReturnLabel(
        string $labelId,
        array $params = [],
        array|ShipEngineConfig|null $config = null,
    ) : array|Label {
        $config = $this->config->merge($config);

        $response = ShipEngineClient::post(
            "labels/{$labelId}/return",
            $this->config->merge($config),
            $params,
        );

        if ($config->asObject) {
            return new Label($response);
        }

        return $response;
    }

    /**
     * @see https://shipengine.github.io/shipengine-openapi/#operation/get_tracking_log_from_label
     * @throws GuzzleException|UnknownProperties
     */
    public function getLabelTrackingInformation(
        string $labelId,
        array|ShipEngineConfig|null $config = null,
    ) : array|TrackingInformation {
        $config = $this->config->merge($config);

        $response = ShipEngineClient::get(
            "labels/{$labelId}/return",
            $this->config->merge($config),
        );

        if ($config->asObject) {
            return new TrackingInformation($response);
        }

        return $response;
    }

    /**
     * @see https://shipengine.github.io/shipengine-openapi/#operation/void_label
     * @throws GuzzleException|UnknownProperties
     */
    public function voidLabelById(
        string $labelId,
        array|ShipEngineConfig|null $config = null,
    ) : array|VoidLabel {
        $config = $this->config->merge($config);

        $response = ShipEngineClient::put(
            "labels/{$labelId}/void",
            $this->config->merge($config),
        );

        if ($config->asObject) {
            return new VoidLabel($response);
        }

        return $response;
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
     * @return array ['shipments' => Shipment[]]
     *
     * @throws GuzzleException
     * @throws UnknownProperties
     *
     * https://shipengine.github.io/shipengine-openapi/#operation/list_shipments
     */
    public function listShipments(
        array|null $params = null,
        array|ShipEngineConfig $config = null,
    ) : array {
        $config = $this->config->merge($config);
        $response = ShipEngineClient::get(
            'shipments',
            $this->config->merge($config),
            $params,
        );

        if ($config->asObject && ! empty($response['shipments'])) {
            $response['shipments'] = $this->shipmentsToObjects($response['shipments']);
        }

        return $response;
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
        $config = $this->config->merge($config);

        $response = ShipEngineClient::post(
            'shipments',
            $config,
            $params,
        );

        if (! $response['has_errors'] && $config->asObject) {
            $response['shipments'] = $this->shipmentsToObjects($response['shipments']);
        }

        return $response;
    }

    /**
     * @param string $external_id
     * @param array|ShipEngineConfig|null $config
     *
     * @return array|Shipment
     *
     * @throws GuzzleException
     * @throws UnknownProperties
     *
     * https://shipengine.github.io/shipengine-openapi/#operation/get_shipment_by_external_id
     */
    public function getShipmentByExternalID(
        string $external_id,
        array|ShipEngineConfig $config = null,
    ) : array|Shipment {
        $config = $this->config->merge($config);
        $response = ShipEngineClient::get(
            "shipments/external_shipment_id/$external_id",
            $config,
        );

        if ($config->asObject) {
            return new Shipment($response);
        }

        return $response;
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
     * @return array|Shipment
     *
     * @throws GuzzleException
     * @throws UnknownProperties
     *
     * https://shipengine.github.io/shipengine-openapi/#operation/get_shipment_by_id
     */
    public function getShipmentById(
        string $id,
        array|ShipEngineConfig $config = null,
    ) : array|Shipment {
        $config = $this->config->merge($config);

        $response = ShipEngineClient::get(
            "shipments/$id",
            $config,
        );

        if ($config->asObject) {
            return new Shipment($response);
        }

        return $response;
    }

    /**
     * @param string $id
     * @param array $params
     * @param array|ShipEngineConfig|null $config
     *
     * @return array|Shipment
     *
     * @throws GuzzleException
     * @throws UnknownProperties
     *
     * https://shipengine.github.io/shipengine-openapi/#operation/update_shipment
     */
    public function updateShipmentById(
        string $id,
        array $params,
        array|ShipEngineConfig $config = null,
    ) : array|Shipment {
        $config = $this->config->merge($config);

        $response = ShipEngineClient::put(
            "shipments/$id",
            $this->config->merge($config),
            $params,
        );

        if ($config->asObject) {
            return new Shipment($response);
        }

        return $response;
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

    /**
     * @throws UnknownProperties
     */
    private function shipmentsToObjects(array $shipments) : array
    {
        $shipment_objects = [];
        foreach ($shipments as $shipment) {
            $shipment_objects[] = new Shipment($shipment);
        }

        return $shipment_objects;
    }

    /**
     * @throws UnknownProperties
     */
    private function labelsToObjects(array $labels) : array
    {
        $label_objects = [];
        foreach ($labels as $label) {
            $label_objects[] = new Label($label);
        }

        return $label_objects;
    }
}
