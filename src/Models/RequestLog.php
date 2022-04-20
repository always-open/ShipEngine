<?php

namespace BluefynInternational\ShipEngine\Models;

use Illuminate\Database\Eloquent\Model;

class RequestLog extends Model
{
    protected $casts = [
        'occurred_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'body' => 'json',
        'response' => 'json',
    ];

    public function getTable()
    {
        return config('shipengine.request_log_table_name');
    }
}
