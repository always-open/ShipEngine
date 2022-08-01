<?php

namespace BluefynInternational\ShipEngine\Models;

use AlwaysOpen\RequestLogger\Models\RequestLogBaseModel;
use BluefynInternational\ShipEngine\Observers\RequestLogObserver;

/**
 * BluefynInternational\ShipEngine\Models\RequestLog
 *
 * @property string|null          $path
 * @property string|null          $params
 * @property string               $http_method
 * @property int|null             $response_code
 * @property array|string|null    $body
 * @property array|string|null    $response
 * @property string|null          $exception
 * @property \Carbon\Carbon|null  $occurred_at
 */
class RequestLog extends RequestLogBaseModel
{
    protected static function boot()
    {
        parent::boot();
        parent::observe(RequestLogObserver::class);
    }

    public function getTable()
    {
        return config('shipengine.request_log_table_name');
    }
}
