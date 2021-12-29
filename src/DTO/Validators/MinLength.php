<?php

namespace BluefynInternational\ShipEngine\DTO\Validators;

use Spatie\DataTransferObject\Validation\ValidationResult;
use Spatie\DataTransferObject\Validator;

#[\Attribute(\Attribute::TARGET_PROPERTY | \Attribute::IS_REPEATABLE)]
class MinLength implements Validator
{
    public function __construct(private int $minLength)
    {
    }

    public function validate(mixed $value): ValidationResult
    {
        if (mb_strlen($value) < $this->minLength) {
            return ValidationResult::invalid("$value is shorter than {$this->minLength} characters");
        }

        return ValidationResult::valid();
    }
}
