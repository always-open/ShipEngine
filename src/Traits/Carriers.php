<?php

namespace BluefynInternational\ShipEngine\Traits;

use BluefynInternational\ShipEngine\ShipEngineClient;
use BluefynInternational\ShipEngine\ShipEngineConfig;
use Exception;
use GuzzleHttp\Exception\GuzzleException;

trait Carriers
{
    /**
     * Fetch the carrier accounts connected to your ShipEngine Account.
     *
     * @param array|ShipEngineConfig|null $config Optional configuration overrides for this method call {apiKey:string,
     * baseUrl:string, pageSize:int, retries:int, timeout:int, client:HttpClient|null}
     *
     * @return array An array of **CarrierAccount** objects that correspond the to carrier accounts connected
     * to a given ShipEngine account.
     *
     * @throws GuzzleException|Exception
     */
    public function listCarriers(array|ShipEngineConfig|null $config = null): array
    {
        return ShipEngineClient::get(
            'carriers',
            $this->config->merge($config),
        );
    }
}
