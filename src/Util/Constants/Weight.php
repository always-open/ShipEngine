<?php

namespace BluefynInternational\ShipEngine\Util\Constants;

class Weight
{
    const POUND = "pound";
    const OUNCE = "ounce";
    const GRAM = "gram";
    const KILOGRAM = "kilogram";

    const ALL_SOURCES = [
        self::POUND,
        self::OUNCE,
        self::GRAM,
        self::KILOGRAM,
    ];
}
