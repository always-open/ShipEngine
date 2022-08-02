<?php

namespace AlwaysOpen\ShipEngine\DTO;

use AlwaysOpen\ShipEngine\DTO\Validators\InArray;
use AlwaysOpen\ShipEngine\DTO\Validators\Regex;
use Spatie\DataTransferObject\DataTransferObject;

class Batch extends DataTransferObject
{
    #[InArray(['4x6', 'letter'])]
    public string $label_layout;
    #[InArray(['pdf', 'png', 'zpl'])]
    public string $label_format;
    #[Regex('/^se(-[a-z0-9]+)+$/')]
    public string $batch_id;
    public string $batch_number;
    public string|null $external_batch_id;
    public string|null $batch_notes;
    #[Regex('/^\d{4}-\d{2}-\d{2}T\d{2}:\d{2}:\d{2}(\.\d+)?(Z|[-+]\d{2}:\d{2})$/')]
    public string $created_at;
    #[Regex('/^\d{4}-\d{2}-\d{2}T\d{2}:\d{2}:\d{2}(\.\d+)?(Z|[-+]\d{2}:\d{2})$/')]
    public string $processed_at;
    public int $errors;
    public int $warnings;
    public int $completed;
    public int $forms;
    public int $count;
    public FormDownload $batch_shipments_url;
    public FormDownload $batch_labels_url;
    public FormDownload $batch_errors_url;
    public LabelDownload $label_download;
    public FormDownload $form_download;
    #[InArray(['open', 'queued', 'processing', 'completed', 'completed_with_errors', 'archived', 'notifying', 'invalid'])]
    public string $status;
}
