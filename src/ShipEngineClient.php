<?php

namespace BluefynInternational\ShipEngine;

use BluefynInternational\ShipEngine\Message\RateLimitExceededException;
use BluefynInternational\ShipEngine\Message\ShipEngineException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Request;

class ShipEngineClient
{
    /**
     * @param string $path
     * @param ShipEngineConfig $config
     * @param array|null $params
     *
     * @return array
     * @throws GuzzleException
     */
    public static function get(string $path, ShipEngineConfig $config, null|array $params = null): array
    {
        return self::sendRequestWithRetries('GET', $path, $params, $config);
    }

    /**
     * Implement a POST request and return output
     *
     * @param string $path
     * @param ShipEngineConfig $config
     * @param array|null $params
     *
     * @return array
     * @throws GuzzleException
     */
    public static function post(string $path, ShipEngineConfig $config, array $params = null): array
    {
        return self::sendRequestWithRetries('POST', $path, $params, $config);
    }

    /**
     * Implement a POST request and return output
     *
     * @param string $path
     * @param ShipEngineConfig $config
     * @param array|null $params
     *
     * @return array
     * @throws GuzzleException
     */
    public static function patch(string $path, ShipEngineConfig $config, array $params = null): array
    {
        return self::sendRequestWithRetries('PATCH', $path, $params, $config);
    }

    /**
     * Implement a PUT request and return output
     *
     * @param string $path
     * @param ShipEngineConfig $config
     * @param array|null $params
     *
     * @return array
     * @throws GuzzleException
     */
    public static function put(string $path, ShipEngineConfig $config, array $params = null): array
    {
        return self::sendRequestWithRetries('PUT', $path, $params, $config);
    }

    /**
     * Implement a DELETE request and return output
     *
     * @param string $path
     * @param ShipEngineConfig $config
     *
     * @return array
     * @throws GuzzleException
     */
    public static function delete(string $path, ShipEngineConfig $config): array
    {
        return self::sendRequestWithRetries('DELETE', $path, null, $config);
    }

    /**
     * Send a `REST` request via *ShipEngineClient*.
     *
     * @param string $method
     * @param string $path
     * @param array|null $params
     * @param ShipEngineConfig $config
     *
     * @return array
     *
     * @throws GuzzleException
     */
    private static function sendRequestWithRetries(
        string $method,
        string $path,
        ?array $params,
        ShipEngineConfig $config
    ): array {
        $apiResponse = null;
        for ($retry = 0; $retry <= $config->retries; $retry++) {
            try {
                $apiResponse = self::sendRequest($method, $path, $params, $config);

                break;
            } catch (\RuntimeException $err) {
                if ($retry < $config->retries &&
                    $err instanceof RateLimitExceededException &&
                    $err->retryAfter->s < $config->timeout->s
                ) {
                    // The request was blocked due to exceeding the rate limit.
                    // So wait the specified amount of time and then retry.
                    sleep($err->retryAfter->s);
                } else {
                    throw $err;
                }
            }
        }

        return $apiResponse;
    }

    /**
     * Send a `REST` request via HTTP Messages to ShipEngine API. If the response
     * is successful, the result is returned. Otherwise, an error is thrown.
     *
     * @param string $method
     * @param string $path
     * @param array|null $params
     * @param ShipEngineConfig $config
     *
     * @return array
     *
     * @throws GuzzleException
     */
    private static function sendRequest(
        string $method,
        string $path,
        ?array $params,
        ShipEngineConfig $config
    ): array {
        $requestHeaders = [
            'api-key' => $config->apiKey,
            'User-Agent' => self::deriveUserAgent(),
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ];

        $client = new Client([
                'base_uri' => $config->baseUrl,
                'timeout' => $config->timeout,
                'max_retry_attempts' => $config->retries,
            ]);

        $request = new Request(
            $method,
            self::buildVersionedUrlPath($path),
            $requestHeaders,
            json_encode($params, JSON_UNESCAPED_SLASHES),
        );

        try {
            $response = $client->send(
                $request,
                ['timeout' => $config->timeout->s, 'http_errors' => false]
            );
        } catch (ClientException $err) {
            throw new ShipEngineException(
                "An unknown error occurred while calling the ShipEngine $method API:\n" .
                $err->getMessage(),
                null,
                'ShipEngine',
                'System',
                'Unspecified'
            );
        }

        return self::handleResponse(json_decode((string)$response->getBody(), true));
    }

    private static function buildVersionedUrlPath(string $path) : string
    {
        $api_version = config('shipengine.endpoint.version', 'v1');
        if (! in_array(stripos($path, $api_version), [0 ,1], true)) {
            $path = str_replace('//', '/', '/' . $api_version . '/' . $path);
        }

        return $path;
    }

    /**
     * Handles the response from ShipEngine API.
     *
     * @param array $response
     * @return array
     */
    private static function handleResponse(array $response): array
    {
        if (! isset($response['errors']) || (count($response['errors']) == 0)) {
            return $response;
        }

        $error = $response['errors'][0];

        throw new ShipEngineException(
            $error['message'],
            $response['request_id'],
            $error['error_source'],
            $error['error_type'],
            $error['error_code']
        );
    }

    /**
     * Derive a User-Agent header from the environment. This is the user-agent that will be set on every request
     * via the ShipEngine Client.
     *
     * @returns string
     */
    private static function deriveUserAgent(): string
    {
        $sdk_version = 'shipengine-php/' . ShipEngine::VERSION;

        $os = explode(' ', php_uname());
        $os_kernel = $os[0] . '/' . $os[2];

        $php_version = 'PHP/' . phpversion();

        return $sdk_version . ' ' . $os_kernel . ' ' . $php_version;
    }
}
