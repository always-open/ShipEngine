<?php

namespace BluefynInternational\ShipEngine\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \BluefynInternational\ShipEngine\ShipEngine
 */
class ShipEngine extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'shipengine';
    }
}
