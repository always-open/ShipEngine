<?php

namespace BluefynInternational\ShipEngine\DTO\Validators;

use Spatie\DataTransferObject\Validation\ValidationResult;
use Spatie\DataTransferObject\Validator;

#[\Attribute(\Attribute::TARGET_PROPERTY | \Attribute::IS_REPEATABLE)]
class InArray implements Validator
{
    public function __construct(private array $options)
    {
    }

    public function validate(mixed $value): ValidationResult
    {
        if (! is_null($value) && ! in_array($value, $this->options, true)) {
            return ValidationResult::invalid("$value is not a valid option");
        }

        return ValidationResult::valid();
    }
}
