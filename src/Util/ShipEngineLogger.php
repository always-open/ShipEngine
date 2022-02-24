<?php

namespace BluefynInternational\ShipEngine\Util;

use Psr\Log\LoggerInterface;
use Psr\Log\LoggerTrait;
use Psr\Log\LogLevel;

/**
 * Class ShipEngineLogger
 *
 * @package BluefynInternational\ShipEngine\Util
 */
final class ShipEngineLogger implements LoggerInterface
{
    use LoggerTrait;

    public function log($level, $message, array $context = [])
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
