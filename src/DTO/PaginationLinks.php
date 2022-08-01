<?php

namespace BluefynInternational\ShipEngine\DTO;

use Spatie\DataTransferObject\DataTransferObject;

class PaginationLinks extends DataTransferObject
{
    public FormDownload|null $first;
    public FormDownload|null $last;
    public FormDownload|null $prev;
    public FormDownload|null $next;
}
