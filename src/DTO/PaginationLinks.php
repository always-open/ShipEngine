<?php

namespace BluefynInternational\ShipEngine\DTO;

use BluefynInternational\ShipEngine\DTO\Validators\Regex;
use Spatie\DataTransferObject\DataTransferObject;

class PaginationLinks extends DataTransferObject
{
    public FormDownload $first;
    public FormDownload $last;
    public FormDownload $prev;
    public FormDownload $next;
}
