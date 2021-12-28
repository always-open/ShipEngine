<?php

namespace Bluefyn International\ShipEngine\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Bluefyn International\ShipEngine\ShipEngine
 */
class ShipEngine extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'shipengine';
    }
}
