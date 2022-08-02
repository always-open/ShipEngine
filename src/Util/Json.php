<?php

namespace AlwaysOpen\ShipEngine\Util;

/**
 * Helper functions for JSON processing.
 */
final class Json
{
    /**
     * Take any JsonSerializable object and an array of $keys to swap out.
     *
     * @param \JsonSerializable $obj
     *
     * @param array $keys
     *
     * @return mixed
     */
    private static function jsonize(\JsonSerializable $obj, array $keys) : mixed
    {
        $json = $obj->jsonSerialize();

        foreach ($keys as $key) {
            $old = $key[0];
            $new = $key[1];
            $json[$new] = $json[$old];
            unset($json[$old]);
        }

        return $json;
    }

    /**
     * Encode a JsonSerializable object, swapping out the $keys in process.
     *
     * @param \JsonSerializable $obj
     *
     * @param array ...$keys
     *
     * @return string
     */
    public static function encode(\JsonSerializable $obj, array ...$keys): string
    {
        $json = self::jsonize($obj, $keys);

        return json_encode($json);
    }

    /**
     * Encode an array of JsonSerializable objects, swapping out the $keys in the process.
     *
     * @param array $objs
     *
     * @param array ...$keys
     *
     * @return string
     */
    public static function encodeArray(array $objs, array ...$keys): string
    {
        $new = [];

        foreach ($objs as $obj) {
            $new[] = self::jsonize($obj, $keys);
        }

        return json_encode($new);
    }
}
