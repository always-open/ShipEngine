<?php

namespace BluefynInternational\ShipEngine\DTO\Validators;

use Spatie\DataTransferObject\Validation\ValidationResult;
use Spatie\DataTransferObject\Validator;

#[\Attribute(\Attribute::TARGET_PROPERTY | \Attribute::IS_REPEATABLE)]
class Regex implements Validator
{
    public function __construct(private string $regexPattern)
    {
    }

    public function validate(mixed $value): ValidationResult
    {
        if (! preg_match($this->regexPattern, $value)) {
            return ValidationResult::invalid("Provided value: $value does not match expected pattern: {$this->regexPattern}");
        }

        return ValidationResult::valid();
    }
}
