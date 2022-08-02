<?php

namespace AlwaysOpen\ShipEngine\DTO\Validators;

use Spatie\DataTransferObject\Validation\ValidationResult;
use Spatie\DataTransferObject\Validator;

#[\Attribute(\Attribute::TARGET_PROPERTY | \Attribute::IS_REPEATABLE)]
class GreaterThanOrEquals implements Validator
{
    public function __construct(private int $min)
    {
    }

    public function validate(mixed $value): ValidationResult
    {
        if ($value < $this->min) {
            return ValidationResult::invalid("$value is less than {$this->min}");
        }

        return ValidationResult::valid();
    }
}
