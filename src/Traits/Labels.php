<?php

namespace BluefynInternational\ShipEngine\Traits;

use BluefynInternational\ShipEngine\DTO\Label;
use BluefynInternational\ShipEngine\DTO\TrackingInformation;
use BluefynInternational\ShipEngine\DTO\VoidLabel;
use BluefynInternational\ShipEngine\ShipEngineClient;
use BluefynInternational\ShipEngine\ShipEngineConfig;
use Exception;
use GuzzleHttp\Exception\GuzzleException;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

trait Labels
{
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
     * @see https://shipengine.github.io/shipengine-openapi/#operation/get_label_by_external_shipment_id
     * @throws GuzzleException|Exception|UnknownProperties
     */
    public function getLabelByExternalShipmentId(
        string $externalShipmentId,
        array $params = [],
        array|ShipEngineConfig|null $config = null,
    ) : array|Label {
        $config = $this->config->merge($config);

        $response = ShipEngineClient::get(
            "labels/external_shipment_id/{$externalShipmentId}",
            $config,
            $params,
        );

        if ($config->asObject) {
            return new Label($response);
        }

        return $response;
    }

    /**
     * @see https://shipengine.github.io/shipengine-openapi/#operation/create_label_from_rate
     * @throws GuzzleException|Exception|UnknownProperties
     */
    public function purchaseLabelWithRateId(
        string $rateId,
        array $params = [],
        array|ShipEngineConfig|null $config = null,
    ) : array|Label {
        $config = $this->config->merge($config);

        $response = ShipEngineClient::post(
            "labels/rates/{$rateId}",
            $config,
            $params,
        );

        if ($config->asObject) {
            return new Label($response);
        }

        return $response;
    }

    /**
     * @see https://shipengine.github.io/shipengine-openapi/#operation/create_label_from_shipment
     * @throws GuzzleException|Exception|UnknownProperties
     */
    public function purchaseLabelWithShipmentId(
        string $shipmentId,
        array $params = [],
        array|ShipEngineConfig|null $config = null,
    ) : array|Label {
        $config = $this->config->merge($config);

        $response = ShipEngineClient::post(
            "labels/shipment/{$shipmentId}",
            $config,
            $params,
        );

        if ($config->asObject) {
            return new Label($response);
        }

        return $response;
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
        $config = $this->config->merge($config);

        $response = ShipEngineClient::get(
            "labels/{$labelId}",
            $config,
            $params,
        );

        if ($config->asObject) {
            return new Label($response);
        }

        return $response;
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