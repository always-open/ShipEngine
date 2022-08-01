<?php

namespace BluefynInternational\ShipEngine\Observers;

use AlwaysOpen\RequestLogger\Models\RequestLogBaseModel;

class RequestLogObserver
{
    public function saving(RequestLogBaseModel $model)
    {
        if (is_string($model->body)) {
            try {
                $model->body = json_decode($model->body, true);
            } catch (\Exception $e) {
                // no op
            }
        }
    }
}
