<?php

namespace BluefynInternational\ShipEngine\Message;

/**
 * Error-level message - an error thrown by the ShipEngine SDK.
 * All other SDK errors inherit from this class.
 *
 * Is throwable.
 * @param string $message
 * @param string|null $requestId
 * @param string|null $source
 * @param string|null $type
 * @param string|null $errorCode
 * @param string|null $url
 *@package ShipEngine\Message
 */
class ShipEngineException extends \RuntimeException implements \JsonSerializable
{
    /**
     * If the error came from the ShipEngine server (as opposed to a client-side error)
     * then this is the unique ID of the HTTP request that returned the error.
     * You can use this ID when contacting ShipEngine support for help.
     *
     * @var string|null
     */
    public string|null $requestId;

    /**
     * A code that indicates the specific error that occurred, such as missing a
     * required field, an invalid address, a timeout, etc.
     *
     * @var string|null
     */
    public string|null $errorCode;

    /**
     * Indicates where the error originated. This lets you know whether you should
     * contact ShipEngine for support or if you should contact the carrier or
     * marketplace instead.
     *
     * @link https://www.shipengine.com/docs/errors/codes/#error-source
     * @var string|null
     */
    public string|null $source;

    /**
     * Indicates the type of error that occurred, such as a validation error, a
     * security error, etc.
     *
     * @link https://www.shipengine.com/docs/errors/codes/#error-type
     * @var string|null
     */
    public string|null $type;

    /**
     * Some errors include a URL that you can visit to learn more about the error,
     * find out how to resolve it, or get support.
     *
     * @var string|null
     */
    public string|null $url;

    /**
     * ShipEngineException constructor - Instantiates a client-side error or server-side error.
     *
     * @param string $message
     * @param string|null $requestId
     * @param string|null $source
     * @param string|null $type
     * @param string|null $errorCode
     * @param string|null $url
     */
    public function __construct(
        string $message,
        string|null $requestId = null,
        string|null $source = null,
        string|null $type = null,
        string|null $errorCode = null,
        string|null $url = null
    ) {
        parent::__construct($message);

        $this->requestId = $requestId;
        $this->source = $source ?? 'shipengine';
        $this->type = $type;
        $this->errorCode = $errorCode;
        $this->url = $url ?? 'https://www.shipengine.com/docs/errors/codes/';
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize() : array
    {
        return [
            'requestId' => $this->requestId,
            'source' => $this->source,
            'type' => $this->type,
            'errorCode' => $this->errorCode,
            'message' => $this->message,
            'url' => $this->url
        ];
    }
}
