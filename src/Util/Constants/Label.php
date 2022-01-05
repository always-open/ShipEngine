<?php

namespace BluefynInternational\ShipEngine\Util\Constants;

class Label
{
    const FORMAT_PDF = "pdf";
    const FORMAT_ZPL = "zpl";
    const FORMAT_PNG = "png";

    const ALL_FORMATS = [
        self::FORMAT_PDF,
        self::FORMAT_PNG,
        self::FORMAT_ZPL,
    ];
}
