<?php

namespace AlwaysOpen\ShipEngine\Traits;

use AlwaysOpen\ShipEngine\DTO\Batch;
use AlwaysOpen\ShipEngine\DTO\BatchError;
use AlwaysOpen\ShipEngine\DTO\PaginationLinks;
use AlwaysOpen\ShipEngine\ShipEngineClient;
use AlwaysOpen\ShipEngine\ShipEngineConfig;
use Exception;
use GuzzleHttp\Exception\GuzzleException;

trait Batches
{
    use BaseCalls;

    /**
     * @see https://shipengine.github.io/shipengine-openapi/#operation/list_batches
     *
     * @throws Exception|GuzzleException
     */
    public function getBatches(
        array $params,
        array|ShipEngineConfig|null $config = null,
    ): array {
        return $this->retrieveList(
            'batches',
            $params,
            $config,
            'batches',
            Batch::class,
        );
    }

    /**
     * @see https://shipengine.github.io/shipengine-openapi/#operation/create_batch
     *
     * @throws Exception|GuzzleException
     */
    public function createBatch(
        array $batch,
        array|ShipEngineConfig|null $config = null,
    ): array|Batch {
        $config = $this->config->merge($config);

        $response = ShipEngineClient::post(
            'batches',
            $config,
            $batch
        );

        if ($config->asObject) {
            return new Batch($response);
        }

        return $response;
    }

    /**
     * @see https://shipengine.github.io/shipengine-openapi/#operation/get_batch_by_external_id
     *
     * @throws Exception|GuzzleException
     */
    public function getBatchByExternalId(
        string $externalBatchId,
        array|ShipEngineConfig|null $config = null,
    ): array|Batch {
        $config = $this->config->merge($config);

        $response = ShipEngineClient::get(
            "batches/external_batch_id/$externalBatchId",
            $config,
        );

        if ($config->asObject) {
            return new Batch($response);
        }

        return $response;
    }

    /**
     * @see https://shipengine.github.io/shipengine-openapi/#operation/delete_batch
     *
     * @throws Exception|GuzzleException
     */
    public function deleteBatchById(
        string $batchId,
        array|ShipEngineConfig|null $config = null,
    ): array|string|null {
        return ShipEngineClient::delete(
            "batches/$batchId",
            $this->config->merge($config),
        );
    }

    /**
     * @see https://shipengine.github.io/shipengine-openapi/#operation/get_batch_by_id
     *
     * @throws Exception|GuzzleException
     */
    public function getBatchById(
        string $batchId,
        array|ShipEngineConfig|null $config = null,
    ): array|Batch {
        $config = $this->config->merge($config);

        $response = ShipEngineClient::get(
            "batches/$batchId",
            $config,
        );

        if ($config->asObject) {
            return new Batch($response);
        }

        return $response;
    }

    /**
     * @see https://shipengine.github.io/shipengine-openapi/#operation/update_batch
     *
     * @throws Exception|GuzzleException
     */
    public function updateBatchById(
        string $batchId,
        array $batch,
        array|ShipEngineConfig|null $config = null,
    ): array|null {
        return ShipEngineClient::put(
            "batches/$batchId",
            $this->config->merge($config),
            $batch
        );
    }

    /**
     * @see https://shipengine.github.io/shipengine-openapi/#operation/add_to_batch
     *
     * @throws Exception|GuzzleException
     */
    public function addToBatch(
        string $batchId,
        array $payload,
        array|ShipEngineConfig|null $config = null,
    ): array|null {
        return ShipEngineClient::post(
            "batches/$batchId/add",
            $this->config->merge($config),
            $payload
        );
    }

    /**
     * @see https://shipengine.github.io/shipengine-openapi/#operation/list_batch_errors
     *
     * @throws Exception|GuzzleException
     */
    public function getBatchErrors(
        string $batchId,
        array $payload = [],
        array|ShipEngineConfig|null $config = null,
    ): array {
        $config = $this->config->merge($config);
        $response = ShipEngineClient::get(
            "batches/$batchId/errors",
            $config,
            $payload,
        );

        if ($config->asObject && $response['errors']) {
            $response['errors'] = $this->listToObjects($response['errors'], BatchError::class);
            $response['links'] = new PaginationLinks($response['links']);
        }

        return $response;
    }

    /**
     * @see https://shipengine.github.io/shipengine-openapi/#operation/process_batch
     *
     * @throws Exception|GuzzleException
     */
    public function processBatchIdLabels(
        string $batchId,
        array $payload = [],
        array|ShipEngineConfig|null $config = null,
    ): array|null {
        return ShipEngineClient::post(
            "batches/$batchId/process/labels",
            $this->config->merge($config),
            $payload
        );
    }

    /**
     * @see https://shipengine.github.io/shipengine-openapi/#operation/remove_from_batch
     *
     * @throws Exception|GuzzleException
     */
    public function removeFromBatch(
        string $batchId,
        array $payload = [],
        array|ShipEngineConfig|null $config = null,
    ): array|null {
        return ShipEngineClient::post(
            "batches/$batchId/remove",
            $this->config->merge($config),
            $payload
        );
    }
}
