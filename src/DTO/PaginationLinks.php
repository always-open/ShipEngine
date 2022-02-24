<?php

namespace BluefynInternational\ShipEngine\DTO;

use Spatie\DataTransferObject\DataTransferObject;

class PaginationLinks extends DataTransferObject
{
    public FormDownload $first;
    public FormDownload $last;
    public FormDownload $prev;
    public FormDownload $next;
}
