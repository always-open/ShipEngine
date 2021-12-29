<?php

namespace BluefynInternational\ShipEngine\Util;

/**
 * Collects helper functions for Array presenting them as static methods.
 */
final class Arr
{
    /**
     * Create a new associative array that only includes the given $keys.
     */
    public static function subArray(array $old, ...$keys): array
    {
        return array_filter($old, function ($key) use ($keys) {
            return in_array($key, $keys, true);
        }, ARRAY_FILTER_USE_KEY);
    }

    /**
     * Flatten a multi-dimensional array into a single dimension.
     */
    public static function flatten(array $arr): array
    {
        $result = [];

        foreach ($arr as $key => $value) {
            if (is_array($value)) {
                $result = array_merge($result, self::flatten($value));
            } else {
                $result = array_merge($result, [$key => $value]);
            }
        }

        return $result;
    }
}
