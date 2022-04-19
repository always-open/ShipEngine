<?php

namespace BluefynInternational\ShipEngine\Traits;

use BluefynInternational\ShipEngine\DTO\PackageType;
use BluefynInternational\ShipEngine\ShipEngineClient;
use BluefynInternational\ShipEngine\ShipEngineConfig;
use GuzzleHttp\Exception\GuzzleException;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

trait PackageTypes
{
    use listToObjects;

    /**
     * @see https://shipengine.github.io/shipengine-openapi/#operation/list_package_types
     *
     * @throws UnknownProperties|GuzzleException
     */
    public function listPackages(
        array|ShipEngineConfig|null $config = null,
    ): array {
        $config = $this->config->merge($config);
        $response = ShipEngineClient::get(
            'packages',
            $config,
        );

        if ($config->asObject) {
            $response['packages'] = $this->listToObjects($response['packages'], PackageType::class);
        }

        return $response;
    }

    /**
     * @see https://shipengine.github.io/shipengine-openapi/#operation/create_package_type
     *
     * @throws UnknownProperties|GuzzleException
     */
    public function createCustomPackageType(
        array $payload = [],
        array|ShipEngineConfig|null $config = null,
    ): array|PackageType {
        $config = $this->config->merge($config);
        $response = ShipEngineClient::post(
            'packages',
            $config,
            $payload,
        );

        if ($config->asObject) {
            return new PackageType($response);
        }

        return $response;
    }

    /**
     * @see https://shipengine.github.io/shipengine-openapi/#operation/get_package_type_by_id
     *
     * @throws UnknownProperties|GuzzleException
     */
    public function getCustomPackageTypeById(
        string $packageTypeId,
        array|ShipEngineConfig|null $config = null,
    ): array|PackageType {
        $config = $this->config->merge($config);
        $response = ShipEngineClient::get(
            "packages/$packageTypeId",
            $config,
        );

        if ($config->asObject) {
            return new PackageType($response);
        }

        return $response;
    }

    /**
     * @see https://shipengine.github.io/shipengine-openapi/#operation/update_package_type
     *
     * @throws GuzzleException
     */
    public function updateCustomPackageTypeById(
        string $packageTypeId,
        array $payload,
        array|ShipEngineConfig|null $config = null,
    ): array|string|null {
        return ShipEngineClient::put(
            "packages/$packageTypeId",
            $config,
            $payload,
        );
    }

    /**
     * @see https://shipengine.github.io/shipengine-openapi/#operation/update_package_type
     *
     * @throws GuzzleException
     */
    public function deleteCustomPackageTypeById(
        string $packageTypeId,
        array|ShipEngineConfig|null $config = null,
    ): array|string|null {
        return ShipEngineClient::delete(
            "packages/$packageTypeId",
            $config,
        );
    }
}
