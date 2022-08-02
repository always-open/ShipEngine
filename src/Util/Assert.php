<?php

namespace AlwaysOpen\ShipEngine\Util;

use AlwaysOpen\ShipEngine\Message\ValidationException;
use DateInterval;

final class Assert
{
    public function isApiKeyValid(string|null $apiKey): void
    {
        if (empty($apiKey)) {
            throw new ValidationException(
                'A ShipEngine API key must be specified.',
                null,
                'shipengine',
                'validation',
                'field_value_required'
            );
        }
    }

    /**
     * Asserts that the timeout value is valid.
     *
     * @param mixed $timeout
     */
    public function isTimeoutValid(mixed $timeout): void
    {
        if (! $timeout instanceof DateInterval) {
            throw new ValidationException(
                'Timeout is not a DateInterval.',
                null,
                'shipengine',
                'validation',
                'invalid_field_value'
            );
        }

        if ($timeout->invert === 1 || $timeout->s === 0) {
            throw new ValidationException(
                'Timeout must be greater than zero.',
                null,
                'shipengine',
                'validation',
                'invalid_field_value'
            );
        }
    }

    public function isRetriesValid(int $retries) : void
    {
        if ($retries < 0) {
            throw new ValidationException(
                'Retries must be zero or greater.',
                null,
                'shipengine',
                'validation',
                'invalid_field_value'
            );
        }
    }

    public function isRequestLimitPerMinuteValid(int $requestsPerMinute) : void
    {
        if ($requestsPerMinute < 0) {
            throw new ValidationException(
                'Requests limit per minute must be zero or greater.',
                null,
                'shipengine',
                'validation',
                'invalid_field_value'
            );
        }
    }
}
