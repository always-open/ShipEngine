<?php

namespace BluefynInternational\ShipEngine\Traits;

use BluefynInternational\ShipEngine\DTO\Shipment;
use BluefynInternational\ShipEngine\ShipEngineClient;
use BluefynInternational\ShipEngine\ShipEngineConfig;
use Exception;
use GuzzleHttp\Exception\GuzzleException;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

trait Shipments
{
    use BaseCalls;

    /**
     * @param array|null $params
     * @param array|ShipEngineConfig|null $config
     *
     * @return array ['shipments' => Shipment[]]
     *
     * @throws GuzzleException|Exception|UnknownProperties
     *
     * https://shipengine.github.io/shipengine-openapi/#operation/list_shipments
     */
    public function listShipments(
        array|null $params = null,
        array|ShipEngineConfig $config = null,
    ) : array {
        return $this->retrieveList(
            'shipments',
            $params,
            $config,
            'shipments',
            Shipment::class,
        );
    }

    /**
     * @param array|null $params
     * @param array|ShipEngineConfig|null $config
     *
     * @return array
     *
     * @throws GuzzleException|Exception
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

        if (
            ! ($response['has_errors'] ?? null)
            && $config->asObject
        ) {
            $response['shipments'] = $this->listToObjects($response['shipments'], Shipment::class);
        }

        return $response;
    }

    /**
     * @param string $external_id
     * @param array|ShipEngineConfig|null $config
     *
     * @return array|Shipment
     *
     * @throws GuzzleException|Exception|UnknownProperties
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
     * @throws GuzzleException|Exception
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
     * @throws GuzzleException|Exception|UnknownProperties
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
     * @throws GuzzleException|Exception|UnknownProperties
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
            $config,
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
     * @return array|null
     *
     * @throws GuzzleException|Exception
     *
     * https://shipengine.github.io/shipengine-openapi/#operation/cancel_shipments
     */
    public function cancelShipment(
        string $id,
        array|ShipEngineConfig $config = null,
    ) : array|null {
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
     * @throws GuzzleException|Exception
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
     * @throws GuzzleException|Exception
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
     * @return array|null
     *
     * @throws GuzzleException|Exception
     *
     * https://shipengine.github.io/shipengine-openapi/#operation/untag_shipment
     */
    public function removeTagFromShipment(
        string $id,
        string $tag_name,
        array|ShipEngineConfig $config = null,
    ) : array|null {
        return ShipEngineClient::delete(
            "shipments/$id/tags/$tag_name",
            $this->config->merge($config),
        );
    }
}
