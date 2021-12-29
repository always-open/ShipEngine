<?php

namespace BluefynInternational\ShipEngine\Message;

/**
 * This error occurs when a field has been set to an invalid value.
 */
final class InvalidFieldValueException extends ShipEngineException
{
    /**
     * The name of the invalid field.
     */
    public string $field_name;

    /**
     * The value of the invalid field.
     */
    public string $field_value;

    /**
     * Instantiates a client-side error.
     *
     * @param string $field_name
     * @param string $reason
     * @param mixed $field_value
     */
    public function __construct(
        string $field_name,
        string $reason,
        mixed $field_value
    ) {
        parent::__construct(
            "$field_name - $reason",
            null,
            null,
            'Validation',
            'Invalid Field Value',
            null
        );
        $this->field_name = $field_name;
        $this->field_value = $field_value;
    }
}
