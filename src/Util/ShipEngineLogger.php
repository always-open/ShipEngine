<?php

namespace AlwaysOpen\ShipEngine\Util;

use Psr\Log\LoggerInterface;
use Psr\Log\LoggerTrait;
use Psr\Log\LogLevel;

/**
 * Class ShipEngineLogger
 *
 * @package AlwaysOpen\ShipEngine\Util
 */
final class ShipEngineLogger implements LoggerInterface
{
    use LoggerTrait;

    public function log(mixed $level, string|\Stringable $message, array $context = []): void
    {
        $message = (string)$message;

        switch ($level) {
            case LogLevel::EMERGENCY:
            case LogLevel::ALERT:
            case LogLevel::CRITICAL:
            case LogLevel::ERROR:
            case LogLevel::WARNING:
            case LogLevel::NOTICE:
            case LogLevel::INFO:
            case LogLevel::DEBUG:
                $this->{$level}($message, $context);

                break;
            default:
                throw new \Psr\Log\InvalidArgumentException(
                    'Severity level not recognized - must be emergency, alert, critical,
                    error, warning, notice, info, or debug.'
                );
        }
    }
}
