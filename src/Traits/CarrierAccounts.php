<?php

namespace BluefynInternational\ShipEngine\Traits;

use BluefynInternational\ShipEngine\DTO\DhlExpressSettings;
use BluefynInternational\ShipEngine\DTO\FedexSettings;
use BluefynInternational\ShipEngine\DTO\UpsSettings;
use BluefynInternational\ShipEngine\ShipEngineClient;
use BluefynInternational\ShipEngine\ShipEngineConfig;
use Exception;
use GuzzleHttp\Exception\GuzzleException;

trait CarrierAccounts
{
    use listToObjects;

    /**
     * @see https://shipengine.github.io/shipengine-openapi/#operation/connect_carrier
     *
     * @throws Exception|GuzzleException
     */
    public function connectCarrierAccount(
        string $carrierName,
        array $payload,
        array|ShipEngineConfig|null $config = null,
    ): array {
        $config = $this->config->merge($config);

        return ShipEngineClient::post(
            "connections/carriers/$carrierName",
            $config,
            $payload,
        );
    }

    /**
     * @see https://shipengine.github.io/shipengine-openapi/#operation/disconnect_carrier
     *
     * @throws Exception|GuzzleException
     */
    public function disconnectACarrier(
        string $carrierName,
        string $carrierId,
        array|ShipEngineConfig|null $config = null,
    ): array|null {
        return ShipEngineClient::delete(
            "connections/carriers/$carrierName/$carrierId",
            $this->config->merge($config),
        );
    }

    /**
     * @see https://shipengine.github.io/shipengine-openapi/#operation/get_carrier_settings
     *
     * @throws Exception|GuzzleException
     */
    public function getCarrierSettings(
        string $carrierName,
        string $carrierId,
        array|ShipEngineConfig|null $config = null,
    ): array|FedexSettings|UpsSettings|DhlExpressSettings {
        $config = $this->config->merge($config);

        $response = ShipEngineClient::get(
            "connections/carriers/$carrierName/$carrierId/settings",
            $config,
        );

        if ($config->asObject) {
            if (array_key_exists('smart_post_hub', $response)) {
                $response = new FedexSettings($response);
            } elseif (array_key_exists('use_carbon_neutral_shipping_program', $response)) {
                $response = new UpsSettings($response);
            } elseif (array_key_exists('should_hide_account_number_on_archive_doc', $response)) {
                $response = new DhlExpressSettings($response);
            }
        }

        return $response;
    }

    /**
     * @see https://shipengine.github.io/shipengine-openapi/#operation/update_carrier_settings
     *
     * @throws Exception|GuzzleException
     */
    public function updateCarrierSettings(
        string $carrierName,
        string $carrierId,
        array $payload,
        array|ShipEngineConfig|null $config = null,
    ): array {
        return ShipEngineClient::get(
            "connections/carriers/$carrierName/$carrierId/settings",
            $this->config->merge($config),
            $payload,
        );
    }
}
