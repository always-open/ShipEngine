<?php

namespace AlwaysOpen\ShipEngine\DTO\Validators;

use Spatie\DataTransferObject\Validation\ValidationResult;
use Spatie\DataTransferObject\Validator;

#[\Attribute(\Attribute::TARGET_PROPERTY | \Attribute::IS_REPEATABLE)]
class MaxLength implements Validator
{
    public function __construct(private int $maxLength)
    {
    }

    public function validate(mixed $value): ValidationResult
    {
        if (mb_strlen($value ?? '') > $this->maxLength) {
            return ValidationResult::invalid("$value is longer than {$this->maxLength} characters");
        }

        return ValidationResult::valid();
    }
}
