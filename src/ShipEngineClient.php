<?php

namespace BluefynInternational\ShipEngine;

use BluefynInternational\ShipEngine\Message\RateLimitExceededException;
use BluefynInternational\ShipEngine\Message\ShipEngineException;
use BluefynInternational\ShipEngine\Models\RequestLog;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Request;
use Illuminate\Http\Response;
use Throwable;

class ShipEngineClient
{
    /**
     * @param string $path
     * @param ShipEngineConfig $config
     * @param array|null $params
     *
     * @return array|null
     * @throws GuzzleException
     */
    public static function get(string $path, ShipEngineConfig $config, null|array $params = null): array|null
    {
        if ($params) {
            $path .=
                (parse_url($path, PHP_URL_QUERY) ? '&' : '?')
                . http_build_query($params);
        }

        return self::sendRequestWithRetries('GET', $path, [], $config);
    }

    /**
     * Implement a POST request and return output
     *
     * @param string $path
     * @param ShipEngineConfig $config
     * @param array|null $body
     *
     * @return array|null
     * @throws GuzzleException
     */
    public static function post(string $path, ShipEngineConfig $config, array $body = null): array|null
    {
        return self::sendRequestWithRetries('POST', $path, $body, $config);
    }

    /**
     * Implement a POST request and return output
     *
     * @param string $path
     * @param ShipEngineConfig $config
     * @param array|null $body
     *
     * @return array|null
     * @throws GuzzleException
     */
    public static function patch(string $path, ShipEngineConfig $config, array $body = null): array|null
    {
        return self::sendRequestWithRetries('PATCH', $path, $body, $config);
    }

    /**
     * Implement a PUT request and return output
     *
     * @param string $path
     * @param ShipEngineConfig $config
     * @param array|null $body
     *
     * @return array|null
     * @throws GuzzleException
     */
    public static function put(string $path, ShipEngineConfig $config, array $body = null): array|null
    {
        return self::sendRequestWithRetries('PUT', $path, $body, $config);
    }

    /**
     * Implement a DELETE request and return output
     *
     * @param string $path
     * @param ShipEngineConfig $config
     *
     * @return array|null
     * @throws GuzzleException
     */
    public static function delete(string $path, ShipEngineConfig $config): array|null
    {
        return self::sendRequestWithRetries('DELETE', $path, null, $config);
    }

    /**
     * Send a `REST` request via *ShipEngineClient*.
     *
     * @param string $method
     * @param string $path
     * @param array|null $body
     * @param ShipEngineConfig $config
     *
     * @return array|null
     *
     * @throws GuzzleException
     */
    private static function sendRequestWithRetries(
        string $method,
        string $path,
        ?array $body,
        ShipEngineConfig $config
    ): array|null {
        $response = [];
        $retry = 0;
        $needs_retry = true;

        do {
            try {
                $response = self::sendRequest($method, $path, $body, $config);
                $needs_retry = false;
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
        } while ($needs_retry && ++$retry <= $config->retries);

        return $response;
    }

    /**
     * Send a `REST` request via HTTP Messages to ShipEngine API. If the response
     * is successful, the result is returned. Otherwise, an error is thrown.
     *
     * @param string $method
     * @param string $path
     * @param array|null $body
     * @param ShipEngineConfig $config
     *
     * @return array|null
     *
     * @throws GuzzleException|ShipEngineException
     */
    private static function sendRequest(
        string $method,
        string $path,
        ?array $body,
        ShipEngineConfig $config
    ): array|null {
        $requestHeaders = [
            'api-key' => $config->apiKey,
            'User-Agent' => self::deriveUserAgent(),
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ];

        $client = new Client([
            'base_uri' => $config->baseUrl,
            'timeout' => $config->timeoutTotal->s,
            'max_retry_attempts' => $config->retries,
        ]);

        $versioned_path = self::buildVersionedUrlPath($path);

        $encoded_body = json_encode($body, JSON_UNESCAPED_SLASHES);

        $request = new Request(
            $method,
            $versioned_path,
            $requestHeaders,
            $encoded_body,
        );

        $requestLog = RequestLog::makeFromGuzzle($request);
        if (! is_null($requestLog->body)) {
            $requestLog->body = json_encode($requestLog->body);
        }

        try {
            $response = $client->send(
                $request,
                ['timeout' => $config->timeout->s, 'http_errors' => false]
            );

            if (self::responseIsRateLimit($response)) {
                throw new Exception($response['message']);
            }
        } catch (Exception|Throwable  $err) {
            if (config('shipengine.track_requests')) {
                $requestLog->exception = substr($err->getMessage(), 0, 255);
                $requestLog->save();
            }

            throw new ShipEngineException(
                "An unknown error occurred while calling the ShipEngine $method API:\n" .
                $err->getMessage(),
                null,
                'ShipEngine',
                'System',
                'Unspecified'
            );
        }

        $requestLog->response_code = $response->getStatusCode();
        $requestLog->response = json_decode((string)$response->getBody(), true);

        if (config('shipengine.track_requests')) {
            $requestLog->save();
        }

        return self::handleResponse($requestLog->response, $requestLog->response_code);
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
     * @param array|null $response
     * @param int        $responseCode
     * @return array|null
     */
    private static function handleResponse(array|null $response, int $responseCode): array|null
    {
        if (is_null($response) && $responseCode === Response::HTTP_NO_CONTENT) {
            return null;
        }

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

    private static function responseIsRateLimit(array $response) : bool
    {
        return 'API rate limit exceeded' === ($response['message'] ?? null);
    }
}
