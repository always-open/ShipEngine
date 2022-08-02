<?php

namespace AlwaysOpen\ShipEngine\Util;

/**
 * A string representing a Date, DateTime, or DateTime with Timezone.
 */
final class IsoString
{
    private string $value;

    public function __construct(string $value)
    {
        $this->value = $value;
    }

    public function __toString(): string
    {
        return $this->value;
    }

    /**
     * Returns if the `IsoString` does include a time element.
     */
    public function hasTime(): bool
    {
        return preg_match('/[0-9]*T[0-9]*/', $this->value) == 1;
    }

    /**
     * Returns if the `IsoString` does include a timezone element.
     */
    public function hasTimezone(): bool
    {
        return $this->hasTime() && preg_match('/(?<=T).*[+-][0-9]|Z$/', $this->value) == 1;
    }
}
