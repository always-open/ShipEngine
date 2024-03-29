<?php

namespace AlwaysOpen\ShipEngine\Traits;

use AlwaysOpen\ShipEngine\DTO\Label;
use AlwaysOpen\ShipEngine\DTO\TrackingInformation;
use AlwaysOpen\ShipEngine\DTO\VoidLabel;
use AlwaysOpen\ShipEngine\ShipEngineClient;
use AlwaysOpen\ShipEngine\ShipEngineConfig;
use Exception;
use GuzzleHttp\Exception\GuzzleException;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

trait Labels
{
    use listToObjects;

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
     * @throws GuzzleException|Exception
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
     * @throws GuzzleException|Exception
     */
    public function voidLabelWithLabelId(string $labelId, array|ShipEngineConfig|null $config = null): array
    {
        return ShipEngineClient::put(
            "labels/$labelId/void",
            $this->config->merge($config),
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
     * @throws GuzzleException|Exception
     */
    public function trackUsingLabelId(string $labelId, array|ShipEngineConfig|null $config = null): array
    {
        return ShipEngineClient::get(
            "labels/$labelId/track",
            $this->config->merge($config),
        );
    }

    /**
     * @see https://shipengine.github.io/shipengine-openapi/#operation/list_labels
     * @throws GuzzleException|Exception|UnknownProperties
     */
    public function listLabels(
        array $params = [],
        array|ShipEngineConfig|null $config = null,
    ) : array {
        $config = $this->config->merge($config);

        return $this->retrieveList(
            'labels',
            $params,
            $config,
            'labels',
            Label::class,
        );
    }

    /**
     * @see https://shipengine.github.io/shipengine-openapi/#operation/create_label
     * @throws GuzzleException|Exception|UnknownProperties
     */
    public function purchaseLabel(
        array $params,
        array|ShipEngineConfig|null $config = null,
    ) : array|Label {
        $config = $this->config->merge($config);
        $response = ShipEngineClient::post(
            'labels',
            $config,
            $params,
        );

        if ($config->asObject) {
            return new Label($response);
        }

        return $response;
    }

    /**
     * @throws UnknownProperties|GuzzleException|Exception
     */
    protected function getLabel(
        string $path,
        array $params = [],
        array|ShipEngineConfig|null $config = null,
    ) : array|Label {
        $config = $this->config->merge($config);

        $response = ShipEngineClient::get(
            $path,
            $config,
            $params,
        );

        if ($config->asObject) {
            return new Label($response);
        }

        return $response;
    }

    /**
     * @throws UnknownProperties|GuzzleException|Exception
     */
    protected function postLabel(
        string $path,
        array $payload = [],
        array|ShipEngineConfig|null $config = null,
    ) : array|Label {
        $config = $this->config->merge($config);

        $response = ShipEngineClient::post(
            $path,
            $config,
            $payload,
        );

        if ($config->asObject) {
            return new Label($response);
        }

        return $response;
    }

    /**
     * @see https://shipengine.github.io/shipengine-openapi/#operation/get_label_by_external_shipment_id
     * @throws GuzzleException|Exception|UnknownProperties
     */
    public function getLabelByExternalShipmentId(
        string $externalShipmentId,
        array $params = [],
        array|ShipEngineConfig|null $config = null,
    ) : array|Label {
        return $this->getLabel(
            "labels/external_shipment_id/{$externalShipmentId}",
            $params,
            $config,
        );
    }

    /**
     * @see https://shipengine.github.io/shipengine-openapi/#operation/create_label_from_rate
     * @throws GuzzleException|Exception|UnknownProperties
     */
    public function purchaseLabelWithRateId(
        string $rateId,
        array $payload = [],
        array|ShipEngineConfig|null $config = null,
    ) : array|Label {
        return $this->postLabel(
            "labels/rates/{$rateId}",
            $payload,
            $config,
        );
    }

    /**
     * @see https://shipengine.github.io/shipengine-openapi/#operation/create_label_from_shipment
     * @throws GuzzleException|Exception|UnknownProperties
     */
    public function purchaseLabelWithShipmentId(
        string $shipmentId,
        array $payload = [],
        array|ShipEngineConfig|null $config = null,
    ) : array|Label {
        return $this->postLabel(
            "labels/shipment/{$shipmentId}",
            $payload,
            $config,
        );
    }

    /**
     * @see https://shipengine.github.io/shipengine-openapi/#operation/get_label_by_id
     * @throws GuzzleException|Exception|UnknownProperties
     */
    public function getLabelById(
        string $labelId,
        array $params = [],
        array|ShipEngineConfig|null $config = null,
    ) : array|Label {
        return $this->getLabel(
            "labels/{$labelId}",
            $params,
            $config,
        );
    }

    /**
     * @see https://shipengine.github.io/shipengine-openapi/#operation/create_return_label
     * @throws GuzzleException|Exception|UnknownProperties
     */
    public function createReturnLabel(
        string $labelId,
        array $params = [],
        array|ShipEngineConfig|null $config = null,
    ) : array|Label {
        $config = $this->config->merge($config);

        $response = ShipEngineClient::post(
            "labels/{$labelId}/return",
            $config,
            $params,
        );

        if ($config->asObject) {
            return new Label($response);
        }

        return $response;
    }

    /**
     * @see https://shipengine.github.io/shipengine-openapi/#operation/get_tracking_log_from_label
     * @throws GuzzleException|Exception|UnknownProperties
     */
    public function getLabelTrackingInformation(
        string $labelId,
        array|ShipEngineConfig|null $config = null,
    ) : array|TrackingInformation {
        $config = $this->config->merge($config);

        $response = ShipEngineClient::get(
            "labels/{$labelId}/track",
            $config,
        );

        if ($config->asObject) {
            return new TrackingInformation($response);
        }

        return $response;
    }

    /**
     * @see https://shipengine.github.io/shipengine-openapi/#operation/void_label
     * @throws GuzzleException|Exception|UnknownProperties
     */
    public function voidLabelById(
        string $labelId,
        array|ShipEngineConfig|null $config = null,
    ) : array|VoidLabel {
        $config = $this->config->merge($config);

        $response = ShipEngineClient::put(
            "labels/{$labelId}/void",
            $config,
        );

        if ($config->asObject) {
            return new VoidLabel($response);
        }

        return $response;
    }
}
