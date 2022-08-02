<?php

namespace AlwaysOpen\ShipEngine\Message;

class ShipEngineException extends \RuntimeException implements \JsonSerializable
{
    public function __construct(
        string $message,
        public string|null $requestId = null,
        public string|null $source = null,
        public string|null $type = null,
        public string|null $errorCode = null,
        public string|null $url = null
    ) {
        parent::__construct($message);

        $this->source = $source ?? 'ShipEngine';
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
            'url' => $this->url,
        ];
    }
}
