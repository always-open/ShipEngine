<?php

namespace AlwaysOpen\ShipEngine\Message;

use DateInterval;

/**
 * This error occurs when a request to ShipEngine API is blocked due to the
 * rate limit being exceeded.
 *
 * @package ShipEngine\Message
 */
final class RateLimitExceededException extends ShipEngineException
{
    /**
     * The amount of time (in SECONDS) to wait before retrying the request.
     *
     * @var DateInterval
     */
    public DateInterval $retryAfter;

    /**
     * RateLimitExceededException constructor - Instantiates a server-side error.
     *
     * @param DateInterval $retryAfter
     * @param string|null $source
     * @param string|null $requestId
     * @param string      $message
     */
    public function __construct(
        DateInterval $retryAfter,
        string|null $source = null,
        string|null $requestId = null,
        string $message = 'You have exceeded the rate limit.',
    ) {
        parent::__construct(
            $message,
            $requestId,
            $source,
            'System',
            'Rate Limit Exceeded',
            'https://www.shipengine.com/docs/rate-limits'
        );

        $this->retryAfter = $retryAfter;
    }
}
