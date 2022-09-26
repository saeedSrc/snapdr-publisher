<?php

namespace App\Helpers;

class Helpers
{
    public static function getClassName(object $object): string
    {
        $class = get_class($object);

        return substr($class, strrpos($class, '\\') + 1);
    }
}
