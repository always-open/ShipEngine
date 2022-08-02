<?php

namespace AlwaysOpen\ShipEngine\Traits;

use AlwaysOpen\ShipEngine\DTO\CurrencyAmount;
use AlwaysOpen\ShipEngine\ShipEngineClient;
use AlwaysOpen\ShipEngine\ShipEngineConfig;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

trait Insurance
{
    public function disconnectShipsuranceAccount(
        array|ShipEngineConfig|null $config = null,
    ): array {
        return ShipEngineClient::delete(
            'connections/insurance/shipsurance',
            $this->config->merge($config),
        );
    }

    public function connectShipsuranceAccount(
        array $payload,
        array|ShipEngineConfig|null $config = null,
    ): array {
        return ShipEngineClient::post(
            'connections/insurance/shipsurance',
            $this->config->merge($config),
            $payload
        );
    }

    /**
     * @throws UnknownProperties
     */
    public function addFundsToInsurance(
        array $payload,
        array|ShipEngineConfig|null $config = null,
    ): array|CurrencyAmount {
        $config = $this->config->merge($config);
        $response = ShipEngineClient::patch(
            'connections/insurance/shipsurance',
            $config,
            $payload
        );

        if ($config->asObject) {
            return new CurrencyAmount($response);
        }

        return $response;
    }

    /**
     * @throws UnknownProperties
     */
    public function getInsuranceFundsBalance(
        array|ShipEngineConfig|null $config = null,
    ): array|CurrencyAmount {
        $config = $this->config->merge($config);
        $response = ShipEngineClient::patch(
            'insurance/shipsurance/balance',
            $config,
        );

        if ($config->asObject) {
            return new CurrencyAmount($response);
        }

        return $response;
    }
}
