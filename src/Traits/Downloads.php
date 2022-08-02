<?php

namespace AlwaysOpen\ShipEngine\Traits;

use AlwaysOpen\ShipEngine\ShipEngineClient;
use AlwaysOpen\ShipEngine\ShipEngineConfig;

trait Downloads
{
    public function downloadFile(
        string $directory,
        string $subDirectory,
        string $fileName,
        array $params = [],
        array|ShipEngineConfig|null $config = null,
    ): array {
        return ShipEngineClient::get(
            "downloads/$directory/$subDirectory/$fileName",
            $this->config->merge($config),
            $params,
        );
    }
}
