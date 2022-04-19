<?php

namespace BluefynInternational\ShipEngine\Traits;

use BluefynInternational\ShipEngine\DTO\TrackingInformation;
use BluefynInternational\ShipEngine\ShipEngineClient;
use BluefynInternational\ShipEngine\ShipEngineConfig;
use GuzzleHttp\Exception\GuzzleException;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

trait Tracking
{
    /**
     * @see https://shipengine.github.io/shipengine-openapi/#operation/get_tracking_log
     *
     * @throws GuzzleException|UnknownProperties
     */
    public function getTrackingInformation(
        string $carrier_code,
        string $tracking_number,
        array|ShipEngineConfig $config = null,
    ) : array|TrackingInformation {
        $config = $this->config->merge($config);
        $response = ShipEngineClient::get(
            "tracking?carrier_code=$carrier_code&tracking_number=$tracking_number",
            $config,
        );

        if ($config->asObject) {
            return new TrackingInformation($response);
        }

        return $response;
    }

    /**
     * @see https://shipengine.github.io/shipengine-openapi/#operation/start_tracking
     *
     * @throws GuzzleException
     */
    public function startTrackingPackage(
        string $carrier_code,
        string $tracking_number,
        array|ShipEngineConfig $config = null,
    ) : array|null {
        return ShipEngineClient::post(
            "tracking/start?carrier_code=$carrier_code&tracking_number=$tracking_number",
            $this->config->merge($config),
        );
    }

    /**
     * @see https://shipengine.github.io/shipengine-openapi/#operation/stop_tracking
     *
     * @throws GuzzleException
     */
    public function stopTrackingPackage(
        string $carrier_code,
        string $tracking_number,
        array|ShipEngineConfig $config = null,
    ) : array|null {
        return ShipEngineClient::post(
            "tracking/stop?carrier_code=$carrier_code&tracking_number=$tracking_number",
            $this->config->merge($config),
        );
    }
}
