<?php

namespace BluefynInternational\ShipEngine\Models;

use Illuminate\Database\Eloquent\Model;

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
class RequestLog extends Model
{
    protected $casts = [
        'occurred_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'body' => 'json',
        'response' => 'json',
    ];

    protected $dateFormat = 'Y-m-d H:i:s.u';

    public function getTable()
    {
        return config('shipengine.request_log_table_name');
    }
}
