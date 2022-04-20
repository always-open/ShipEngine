<?php

return [
    /*
    |--------------------------------------------------------------------------
    | ShipEngine configurations
    |--------------------------------------------------------------------------
    |
    | API Key used to authenticate with ShipEngine APIs.
    | https://www.shipengine.com/docs/auth/
    |
    */
    'credentials' => [
        'key' => env('SHIP_ENGINE_API_KEY'),
    ],

    /*
    |--------------------------------------------------------------------------
    | ShipEngine configurations
    |--------------------------------------------------------------------------
    |
    | Values used to set configuration of ShipEngine API integration.
    |
    */
    'endpoint' => [
        'version'  => env('SHIP_ENGINE_API_VERSION', 'v1'),
        'base'     => env('SHIP_ENGINE_ENDPOINT', 'https://api.shipengine.com/'),
    ],
    'retries'  => env('SHIP_ENGINE_RETRIES', 1),
    'response' => [
        'as_object' => env('SHIP_ENGINE_RESPONSE_AS_OBJECT', false),
        'page_size' => env('SHIP_ENGINE_RESPONSE_PAGE_SIZE', 50),
    ],
    'timeout' => 'PT10S',
    'request_log_table_name' => env('SHIP_ENGINE_REQUEST_LOG_TABLE_NAME', 'ship_engine_request_logs'),
];
