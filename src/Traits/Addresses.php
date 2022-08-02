<?php

namespace AlwaysOpen\ShipEngine\Traits;

use AlwaysOpen\ShipEngine\DTO\ParsedAddress;
use AlwaysOpen\ShipEngine\DTO\ValidatedAddress;
use AlwaysOpen\ShipEngine\ShipEngineClient;
use AlwaysOpen\ShipEngine\ShipEngineConfig;
use Exception;
use GuzzleHttp\Exception\GuzzleException;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

trait Addresses
{
    /**
     * @see https://shipengine.github.io/shipengine-openapi/#operation/validate_address
     *
     * @throws GuzzleException|Exception
     */
    public function validateAddress(
        array $params,
        array|ShipEngineConfig|null $config = null,
    ): array|ValidatedAddress {
        $config = $this->config->merge($config);

        $response = ShipEngineClient::post(
            'addresses/validate',
            $this->config->merge($config),
            $params,
        );

        if ($config->asObject) {
            return new ValidatedAddress($response);
        }

        return $response;
    }

    /**
     * @see https://shipengine.github.io/shipengine-openapi/#operation/parse_address
     *
     * @throws UnknownProperties|GuzzleException
     */
    public function parseAddress(
        string $addressText,
        array $addressParts = [],
        array|ShipEngineConfig|null $config = null,
    ): array|ParsedAddress {
        $config = $this->config->merge($config);

        $params = [
            'text' => $addressText,
        ];

        if ($addressParts) {
            $params['address'] = $addressParts;
        }

        $response = ShipEngineClient::put(
            'addresses/recognize',
            $config,
            $params,
        );

        if ($config->asObject) {
            return new ParsedAddress($response);
        }

        return $response;
    }
}
