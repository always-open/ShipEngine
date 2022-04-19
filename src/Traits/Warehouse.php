<?php

namespace BluefynInternational\ShipEngine\Traits;

use BluefynInternational\ShipEngine\DTO\Warehouse as WarehouseDTO;
use BluefynInternational\ShipEngine\ShipEngineClient;
use BluefynInternational\ShipEngine\ShipEngineConfig;
use GuzzleHttp\Exception\GuzzleException;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

trait Warehouse
{
    use BaseCalls;

    /**
     * @see https://shipengine.github.io/shipengine-openapi/#operation/list_warehouses
     *
     * @throws GuzzleException|UnknownProperties
     */
    public function listWarehouse(
        array|ShipEngineConfig $config = null,
    ) : array {
        return $this->retrieveList(
            'warehouses',
            [],
            $config,
            'warehouses',
            WarehouseDTO::class,
        );
    }

    /**
     * @see https://shipengine.github.io/shipengine-openapi/#operation/create_warehouse
     *
     * @throws GuzzleException|UnknownProperties
     */
    public function createWarehouse(
        string $name,
        array $origin_address,
        array $return_address = [],
        array|ShipEngineConfig $config = null,
    ) : array|WarehouseDTO {
        $config = $this->config->merge($config);
        $payload = [
            'name' => $name,
            'origin_address' => $origin_address,
        ];
        if ($return_address) {
            $payload['return_address'] = $return_address;
        }

        $response = ShipEngineClient::post(
            'warehouses',
            $config,
            $payload,
        );

        if ($config->asObject) {
            return new WarehouseDTO($response);
        }

        return $response;
    }

    /**
     * @see https://shipengine.github.io/shipengine-openapi/#operation/get_warehouse_by_id
     *
     * @throws GuzzleException|UnknownProperties
     */
    public function getWarehouseById(
        string $warehouse_id,
        array|ShipEngineConfig $config = null,
    ) : array|WarehouseDTO {
        $config = $this->config->merge($config);

        $response = ShipEngineClient::get(
            "warehouses/{$warehouse_id}",
            $config,
        );

        if ($config->asObject) {
            return new WarehouseDTO($response);
        }

        return $response;
    }

    /**
     * @see https://shipengine.github.io/shipengine-openapi/#operation/update_warehouse
     *
     * @throws GuzzleException
     */
    public function updateWarehouseById(
        string $warehouse_id,
        string $name,
        array $origin_address,
        array $return_address = [],
        array|ShipEngineConfig $config = null,
    ) : array|null {
        $payload = [
            'name' => $name,
            'origin_address' => $origin_address,
        ];
        if ($return_address) {
            $payload['return_address'] = $return_address;
        }

        return ShipEngineClient::put(
            "warehouses/{$warehouse_id}",
            $this->config->merge($config),
            $payload,
        );
    }

    /**
     * @see https://shipengine.github.io/shipengine-openapi/#operation/create_warehouse
     *
     * @throws GuzzleException
     */
    public function deleteWarehouseById(
        string $warehouse_id,
        array|ShipEngineConfig $config = null,
    ) : array|null {
        return ShipEngineClient::delete(
            "warehouses/{$warehouse_id}",
            $this->config->merge($config),
        );
    }
}
