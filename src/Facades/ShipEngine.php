<?php

namespace AlwaysOpen\ShipEngine\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \AlwaysOpen\ShipEngine\ShipEngine
 */
class ShipEngine extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'shipengine';
    }
}
